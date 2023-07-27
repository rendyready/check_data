<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekapAktivitasKasirController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

    }

    public function rekap_laci()
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass();
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama', 'm_w_id')->where('m_w_id', $waroeng_id)->first();
        $data->area_nama = DB::table('m_area')->join('m_w', 'm_w_m_area_id', 'm_area_id')->select('m_area_nama', 'm_area_id')->where('m_w_id', $waroeng_id)->first();
        $data->akses_area = $this->get_akses_area(); //mulai dari 1 - akhir
        $data->akses_pusat = $this->get_akses_pusat(); //1,2,3,4,5
        $data->akses_pusar = $this->get_akses_pusar(); //mulai dari 6 - akhir

        $data->waroeng = DB::table('m_w')
            ->where('m_w_m_area_id', $data->area_nama->m_area_id)
            ->orderby('m_w_id', 'ASC')
            ->get();
        $data->area = DB::table('m_area')
            ->orderby('m_area_id', 'ASC')
            ->get();
        $data->laci = DB::table('rekap_buka_laci')
            ->orderby('r_b_l_id', 'ASC')
            ->get();
        return view('dashboard::rekap_aktiv_laci', compact('data'));
    }

    public function select_waroeng(Request $request)
    {
        $waroeng = DB::table('m_w')
            ->select('m_w_id', 'm_w_nama', 'm_w_code')
            ->where('m_w_m_area_id', $request->id_area)
            ->orderBy('m_w_id', 'asc')
            ->get();
        $data = array();
        foreach ($waroeng as $val) {
            $data[$val->m_w_id] = [$val->m_w_nama];
            $data['all'] = 'all waroeng';
        }
        return response()->json($data);
    }

    public function select_user_laci(Request $request)
    {
        $user = DB::table('users')
            ->join('rekap_buka_laci', 'r_b_l_created_by', 'users_id')
            ->select('users_id', 'name');
        if (in_array(Auth::user()->waroeng_id, $this->get_akses_area())) {
            $user->where('waroeng_id', $request->id_waroeng);
        } else {
            $user->where('waroeng_id', Auth::user()->waroeng_id);
        }
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $user->whereBetween('r_b_l_tanggal', [$start, $end]);
        } else {
            $user->where('r_b_l_tanggal', $request->tanggal);
        }
        $user1 = $user->orderBy('users_id', 'asc')->get();

        $data = array();
        foreach ($user1 as $val) {
            $data[$val->users_id] = [$val->name];
            $data['all'] = 'all operator';
        }
        return response()->json($data);
    }

    public function tampil_laci(Request $request)
    {

        $buka_laci = DB::table('rekap_buka_laci')
            ->join('users', 'users_id', 'r_b_l_created_by')
            ->join('rekap_modal', 'rekap_modal_id', 'r_b_l_rekap_modal_id');

        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $buka_laci->whereBetween('r_b_l_tanggal', [$start, $end]);
        } else {
            $buka_laci->where('r_b_l_tanggal', $request->tanggal);
        }

        if ($request->area != 'all') {
            $buka_laci->where('r_b_l_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $buka_laci->where('r_b_l_m_w_id', $request->waroeng);
                if ($request->operator != 'all') {
                    $buka_laci->where('r_b_l_created_by', $request->operator);
                }
            }
        }

        // Menghitung total data yang cocok dengan filter
        $totalData = $buka_laci->count();
        // Menentukan halaman saat ini dan jumlah data per halaman
        $currentPage = $request->page ?? 1;
        $dataPerPage = 10; // Jumlah data per halaman
        // Mengambil data pengguna dengan manual pagination menggunakan Query Builder
        $offset = ($currentPage - 1) * $dataPerPage;
        $buka_laci->selectRaw('r_b_l_rekap_modal_id, r_b_l_tanggal, name, sum(r_b_l_qty) as laci, r_b_l_m_area_nama, r_b_l_m_w_nama, rekap_modal_sesi')
            ->groupBy('r_b_l_tanggal', 'name', 'r_b_l_rekap_modal_id', 'r_b_l_m_area_nama', 'r_b_l_m_area_id', 'r_b_l_m_w_nama', 'rekap_modal_sesi')
            ->orderBy('r_b_l_m_area_id', 'ASC')
            ->orderBy('r_b_l_tanggal', 'ASC')
            ->orderBy('rekap_modal_sesi', 'ASC')
            ->offset($offset)
            ->limit($dataPerPage);

        $buka_laci = $buka_laci->get();

        $data = array();
        foreach ($buka_laci as $laci) {
            $row = array();
            $row[] = $laci->r_b_l_m_area_nama;
            $row[] = $laci->r_b_l_m_w_nama;
            $row[] = date('d-m-Y', strtotime($laci->r_b_l_tanggal));
            $row[] = $laci->name;
            $row[] = $laci->rekap_modal_sesi;
            $row[] = $laci->laci;
            $row[] = '<a id="button_detail" class="btn btn-sm button_detail btn-info" value="' . $laci->r_b_l_rekap_modal_id . '" title="Detail Nota"><i class="fa-sharp fa-solid fa-eye"></i></a>';
            $data[] = $row;
        }

        $output = [
            "data" => $data,
            "totalData" => $totalData,
            "currentPage" => $currentPage,
        ];

        return response()->json($output);
    }

    public function tampil_lacixxx(Request $request)
    {
        $buka_laci = DB::table('rekap_buka_laci')
            ->join('users', 'users_id', 'r_b_l_created_by')
            ->join('rekap_modal', 'rekap_modal_id', 'r_b_l_rekap_modal_id');
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $buka_laci->whereBetween('r_b_l_tanggal', [$start, $end]);
        } else {
            $buka_laci->where('r_b_l_tanggal', $request->tanggal);
        }
        if ($request->area != 'all') {
            $buka_laci->where('r_b_l_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $buka_laci->where('r_b_l_m_w_id', $request->waroeng);
                if ($request->operator != 'all') {
                    $buka_laci->where('r_b_l_created_by', $request->operator);
                }
            }
        }

        $buka_laci = $buka_laci->selectRaw('r_b_l_rekap_modal_id, r_b_l_tanggal, name, sum(r_b_l_qty) as laci, r_b_l_m_area_nama, r_b_l_m_w_nama, rekap_modal_sesi')
            ->groupby('r_b_l_tanggal', 'name', 'r_b_l_rekap_modal_id', 'r_b_l_m_area_nama', 'r_b_l_m_area_id', 'r_b_l_m_w_nama', 'rekap_modal_sesi')
            ->orderby('r_b_l_m_area_id', 'ASC')
            ->orderby('r_b_l_tanggal', 'ASC')
            ->orderby('rekap_modal_sesi', 'ASC')
            ->get();

        $data = array();
        foreach ($buka_laci as $laci) {
            $row = array();
            $row[] = $laci->r_b_l_m_area_nama;
            $row[] = $laci->r_b_l_m_w_nama;
            $row[] = date('d-m-Y', strtotime($laci->r_b_l_tanggal));
            $row[] = $laci->name;
            $row[] = $laci->rekap_modal_sesi;
            $row[] = $laci->laci;
            $row[] = '<a id="button_detail" class="btn btn-sm button_detail btn-info" value="' . $laci->r_b_l_rekap_modal_id . '" title="Detail Nota"><i class="fa-sharp fa-solid fa-eye"></i></a>';
            $data[] = $row;
        }

        $output = [
            "data" => $data,
        ];
        return response()->json($output);
    }

    public function detail_laci($id)
    {
        $data = DB::table('rekap_buka_laci')
            ->join('users', 'users_id', 'r_b_l_created_by')
            ->where('r_b_l_rekap_modal_id', $id)
            ->first();

        return response()->json($data);
    }

    public function detail_show_laci(Request $request, $id)
    {
        $buka_laci = DB::table('rekap_buka_laci')
            ->where('r_b_l_rekap_modal_id', $id)
            ->where('r_b_l_m_w_id', $request->waroeng)
            ->orderby('r_b_l_created_at', 'ASC')
            ->get();

        foreach ($buka_laci as $laci) {
            $data[] = array(
                'waktu' => date('H:i', strtotime($laci->r_b_l_created_at)),
                'intensitas' => $laci->r_b_l_qty,
                'keterangan' => $laci->r_b_l_keterangan,
            );
        }
        $output = array('data' => $data);
        return response()->json($output);
    }

    public function rekap_hps_menu()
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass();
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama', 'm_w_id')->where('m_w_id', $waroeng_id)->first();
        $data->area_nama = DB::table('m_area')->join('m_w', 'm_w_m_area_id', 'm_area_id')->select('m_area_nama', 'm_area_id')->where('m_w_id', $waroeng_id)->first();
        $data->akses_area = $this->get_akses_area(); //mulai dari 1 - akhir
        $data->akses_pusat = $this->get_akses_pusat(); //1,2,3,4,5
        $data->akses_pusar = $this->get_akses_pusar(); //mulai dari 6 - akhir

        $data->waroeng = DB::table('m_w')
            ->where('m_w_m_area_id', $data->area_nama->m_area_id)
            ->orderby('m_w_id', 'ASC')
            ->get();
        $data->area = DB::table('m_area')
            ->orderby('m_area_id', 'ASC')
            ->get();
        return view('dashboard::rekap_aktiv_menu', compact('data'));
    }

    public function select_user_menu(Request $request)
    {
        $user = DB::table('users')
            ->join('rekap_hapus_menu', 'r_h_m_created_by', 'users_id')
            ->select('users_id', 'name');
        if (in_array(Auth::user()->waroeng_id, $this->get_akses_area())) {
            $user->where('waroeng_id', $request->id_waroeng);
        } else {
            $user->where('waroeng_id', Auth::user()->waroeng_id);
        }
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $user->whereBetween('r_h_m_tanggal', [$start, $end]);
        } else {
            $user->where('r_h_m_tanggal', $request->tanggal);
        }
        $user1 = $user->orderBy('users_id', 'asc')->get();

        $data = array();
        foreach ($user1 as $val) {
            $data[$val->users_id] = [$val->name];
            $data['all'] = 'all operator';
        }
        return response()->json($data);
    }

    public function tampil_hps_menu(Request $request)
    {
        $hps_menu = DB::table('rekap_hapus_menu')
            ->join('users', 'users_id', 'r_h_m_created_by')
            ->join('rekap_modal', 'rekap_modal_id', 'r_h_m_rekap_modal_id');
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $hps_menu->whereBetween('r_h_m_tanggal', [$start, $end]);
        } else {
            $hps_menu->where('r_h_m_tanggal', $request->tanggal);
        }
        if ($request->area != 'all') {
            $hps_menu->where('r_h_m_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $hps_menu->where('r_h_m_m_w_id', $request->waroeng);
                if ($request->operator != 'all') {
                    $hps_menu->where('r_h_m_created_by', $request->operator);
                }
            }
        }
        $hps_menu = $hps_menu->orderby('r_h_m_m_area_id', 'ASC')
            ->orderby('r_h_m_tanggal', 'ASC')
            ->orderby('rekap_modal_sesi', 'ASC')
            ->get();

        $data = array();
        foreach ($hps_menu as $menu) {
            $row = array();
            $row[] = $menu->r_h_m_m_area_nama;
            $row[] = $menu->r_h_m_m_w_nama;
            $row[] = $menu->name;
            $row[] = $menu->rekap_modal_sesi;
            $row[] = date('d-m-Y', strtotime($menu->r_h_m_tanggal));
            $row[] = date('H:i', strtotime($menu->r_h_m_jam));
            $row[] = $menu->r_h_m_nota_code;
            $row[] = $menu->r_h_m_bigboss;
            $row[] = $menu->r_h_m_m_produk_nama;
            $row[] = $menu->r_h_m_qty;
            $row[] = number_format($menu->r_h_m_price);
            $row[] = number_format($menu->r_h_m_nominal_pajak);
            $row[] = number_format($menu->r_h_m_nominal_sc);
            $row[] = number_format(($menu->r_h_m_qty * $menu->r_h_m_price) + $menu->r_h_m_nominal_pajak + $menu->r_h_m_nominal_sc);
            $data[] = $row;
        }

        $output = array("data" => $data);
        return response()->json($output);
    }

    public function rekap_hps_nota()
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass();
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama', 'm_w_id')->where('m_w_id', $waroeng_id)->first();
        $data->area_nama = DB::table('m_area')->join('m_w', 'm_w_m_area_id', 'm_area_id')->select('m_area_nama', 'm_area_id')->where('m_w_id', $waroeng_id)->first();
        $data->akses_area = $this->get_akses_area(); //mulai dari 1 - akhir
        $data->akses_pusat = $this->get_akses_pusat(); //1,2,3,4,5
        $data->akses_pusar = $this->get_akses_pusar(); //mulai dari 6 - akhir

        $data->waroeng = DB::table('m_w')
            ->where('m_w_m_area_id', $data->area_nama->m_area_id)
            ->orderby('m_w_id', 'ASC')
            ->get();
        $data->area = DB::table('m_area')
            ->orderby('m_area_id', 'ASC')
            ->get();
        return view('dashboard::rekap_aktiv_nota', compact('data'));
    }

    public function select_user_nota(Request $request)
    {
        $user = DB::table('users')
            ->join('rekap_hapus_transaksi', 'r_h_t_created_by', 'users_id')
            ->select('users_id', 'name');
        if (in_array(Auth::user()->waroeng_id, $this->get_akses_area())) {
            $user->where('waroeng_id', $request->id_waroeng);
        } else {
            $user->where('waroeng_id', Auth::user()->waroeng_id);
        }
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $user->whereBetween('r_h_t_tanggal', [$start, $end]);
        } else {
            $user->where('r_h_t_tanggal', $request->tanggal);
        }
        $user1 = $user->orderBy('users_id', 'asc')->get();

        $data = array();
        foreach ($user1 as $val) {
            $data[$val->users_id] = [$val->name];
            $data['all'] = 'all operator';
        }
        return response()->json($data);
    }

    public function tampil_hps_nota(Request $request)
    {
        $hps_nota = DB::table('rekap_hapus_transaksi')
            ->join('users', 'users_id', 'r_h_t_created_by')
            ->join('rekap_modal', 'rekap_modal_id', 'r_h_t_rekap_modal_id');
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $hps_nota->whereBetween('r_h_t_tanggal', [$start, $end]);
        } else {
            $hps_nota->where('r_h_t_tanggal', $request->tanggal);
        }
        if ($request->area != 'all') {
            $hps_nota->where('r_h_t_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $hps_nota->where('r_h_t_m_w_id', $request->waroeng);
                if ($request->operator != 'all') {
                    $hps_nota->where('r_h_t_created_by', $request->operator);
                }
            }
        }
        $hps_nota = $hps_nota->orderby('r_h_t_m_area_id', 'ASC')
            ->orderby('r_h_t_tanggal', 'ASC')
            ->orderby('rekap_modal_sesi', 'ASC')
            ->get();

        $data = array();
        foreach ($hps_nota as $nota) {
            $approve = DB::table('rekap_hapus_transaksi')
                ->leftjoin('users', 'users_id', 'r_h_t_approved_by')
                ->select('name')
                ->where('r_h_t_id', $nota->r_h_t_id)
                ->first();

            $row = array();
            $row[] = $nota->r_h_t_m_area_nama;
            $row[] = $nota->r_h_t_m_w_nama;
            $row[] = $nota->name;
            $row[] = $nota->rekap_modal_sesi;
            $row[] = date('d-m-Y', strtotime($nota->r_h_t_tanggal));
            $row[] = date('H:i', strtotime($nota->r_h_t_jam));
            $row[] = $nota->r_h_t_nota_code;
            $row[] = $nota->r_h_t_bigboss;
            $row[] = $approve->name;
            $row[] = number_format($nota->r_h_t_nominal);
            $row[] = number_format($nota->r_h_t_nominal_pajak);
            $row[] = number_format($nota->r_h_t_nominal_sc);
            $row[] = number_format($nota->r_h_t_nominal + $nota->r_h_t_nominal_pajak + $nota->r_h_t_nominal_sc);
            $data[] = $row;
        }

        $output = array("data" => $data);
        return response()->json($output);
    }
}