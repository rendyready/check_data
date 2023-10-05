<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekapWbdController extends Controller
{
    public function index()
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
        return view('dashboard::rekap_wbd', compact('data'));
    }

    public function select_waroeng(Request $request)
    {
        if ($request->id_area != 'all') {
            $waroeng = DB::table('m_w')
                ->select('m_w_id', 'm_w_nama', 'm_w_code')
                ->where('m_w_m_area_id', $request->id_area)
                ->orderBy('m_w_id', 'asc')
                ->get();
            $data = array();
            foreach ($waroeng as $val) {
                $data[$val->m_w_id] = [$val->m_w_nama];
                $data['all'] = ['all waroeng'];
            }
            return response()->json($data);
        }
    }

    public function show_member(Request $request)
    {
        $wbdMember = DB::table('users')
            ->join('rekap_transaksi', DB::raw('CAST(r_t_member_id AS bigint)'), 'users_id')
        // ->join('rekap_transaksi', function ($join) {
        //     $join->on('users_id', '=', DB::raw('CAST(r_t_member_id AS bigint)'))
        //         ->whereRaw('LENGTH(r_t_member_id) = 5');
        // })
            ->join('rekap_transaksi_detail', 'r_t_detail_r_t_id', 'r_t_id')
            ->join('m_produk', 'm_produk_id', 'r_t_detail_m_produk_id')
            ->selectRaw('
                    name as name,
                    max(email) as email,
                    max(r_t_member_id) as r_t_member_id,
                    max(r_t_m_w_nama) as m_w_nama,
                    r_t_tanggal,
                    sum(r_t_detail_nominal + r_t_detail_nominal_pajak + r_t_detail_nominal_sc) as nilaibeli
                ')
            ->whereRaw('LENGTH(r_t_member_id) = 5')
            ->where('m_produk_m_jenis_produk_id', '=', '11');
        if ($request->area != 'all') {
            if ($request->waroeng != 'all') {
                $wbdMember->where('waroeng_id', $request->waroeng);
            }
        }
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $wbdMember->whereBetween('r_t_tanggal', [$start, $end]);
        } else {
            $wbdMember->where('r_t_tanggal', $request->tanggal);
        }
        $wbdMember = $wbdMember->groupBy('r_t_tanggal', 'name')
            ->orderby('r_t_tanggal', 'ASC')
            ->get()->toArray();

        $output = array("data" => $wbdMember);
        return response()->json($output);
    }

    public function detail_member($tanggal, $member)
    {
        $wbdDetail = DB::table('rekap_transaksi')
            ->selectRaw('name,
                    email as email,
                    r_t_member_id as r_t_member_id,
                    r_t_nota_code as r_t_nota_code,
                    r_t_tanggal,
                    m_w_nama,
                    r_t_jam as r_t_jam,
                    r_t_m_area_nama as r_t_m_area_nama,
                    r_t_m_w_nama as r_t_m_w_nama,
                    r_t_detail_m_produk_nama as r_t_detail_m_produk_nama,
                    r_t_detail_qty,
                    (r_t_detail_nominal + r_t_detail_nominal_pajak + r_t_detail_nominal_sc) as nilaibeli')
            ->where('m_produk_m_jenis_produk_id', '=', '11')
            ->join('users', function ($join) {
                $join->on('users_id', '=', DB::raw('CAST(r_t_member_id AS bigint)'))
                    ->whereRaw('LENGTH(r_t_member_id) = 5');
            })
            ->join('rekap_transaksi_detail', 'r_t_id', '=', 'r_t_detail_r_t_id')
            ->join('m_produk', 'r_t_detail_m_produk_id', '=', 'm_produk_id')
            ->join('m_w', 'm_w_id', 'waroeng_id')
            ->where('r_t_tanggal', $tanggal)
            ->where('users_id', $member)
            ->orderby('r_t_tanggal', 'ASC')
            ->get()->toArray();

        $output = array("data" => $wbdDetail);
        return response()->json($output);
    }

    public function show_waroeng(Request $request)
    {
        // $wbdWaroeng = DB::table('rekap_transaksi_detail')
        //     ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
        //     ->join('m_produk', 'r_t_detail_m_produk_id', 'm_produk_id');
        // if ($request->area != 'all') {
        //     $wbdWaroeng->where('r_t_m_area_id', $request->area);
        //     if ($request->waroeng != 'all') {
        //         $wbdWaroeng->where('r_t_m_w_id', $request->waroeng);
        //     }
        // }
        // if (strpos($request->tanggal, 'to') !== false) {
        //     [$start, $end] = explode('to', $request->tanggal);
        //     $wbdWaroeng->whereBetween('r_t_tanggal', [$start, $end]);
        // } else {
        //     $wbdWaroeng->where('r_t_tanggal', $request->tanggal);
        // }
        // $wbdWaroengA = $wbdWaroeng->selectRaw('r_t_tanggal as tanggal,
        //             r_t_m_area_nama as area,
        //             r_t_m_w_nama as waroeng,
        //             r_t_m_w_id as waroeng_id,
        //             sum(r_t_detail_nominal) as nominal_total
        //         ')
        //     ->groupBy('tanggal', 'area', 'waroeng', 'waroeng_id')
        //     ->where('m_produk_m_jenis_produk_id', '11')
        //     ->orderby('tanggal', 'ASC')
        //     ->get();
        // $wbdWaroengB = $wbdWaroeng->selectRaw('r_t_tanggal as tanggal,
        //             r_t_m_area_nama as area,
        //             r_t_m_w_nama as waroeng,
        //             r_t_m_w_id as waroeng_id,
        //             sum(r_t_detail_reguler_price * r_t_detail_qty) as nominal_member
        //         ')
        //     ->join('users', function ($join) {
        //         $join->on('users_id', '=', DB::raw('CAST(r_t_member_id AS bigint)'))
        //             ->whereRaw('LENGTH(r_t_member_id) = 5');
        //     })
        //     ->groupBy('tanggal', 'area', 'waroeng', 'waroeng_id')
        //     ->where('m_produk_m_jenis_produk_id', '11')
        //     ->orderby('tanggal', 'ASC')
        //     ->get();

        $wbdWaroengA = DB::table('rekap_transaksi_detail')
            ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
            ->join('m_produk', 'r_t_detail_m_produk_id', 'm_produk_id')
            ->where('m_produk_m_jenis_produk_id', '11');

        if ($request->area != 'all') {
            $wbdWaroengA->where('r_t_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $wbdWaroengA->where('r_t_m_w_id', $request->waroeng);
            }
        }

        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $wbdWaroengA->whereBetween('r_t_tanggal', [$start, $end]);
        } else {
            $wbdWaroengA->where('r_t_tanggal', $request->tanggal);
        }

        $wbdWaroengA->selectRaw('r_t_tanggal as tanggal,
        r_t_m_area_nama as area,
        r_t_m_w_nama as waroeng,
        r_t_m_w_id as waroeng_id,
        sum(r_t_detail_nominal) as nominal_total
    ')
            ->groupBy('tanggal', 'area', 'waroeng', 'waroeng_id')
            ->orderBy('tanggal', 'ASC');

        $wbdWaroengB = DB::table('rekap_transaksi_detail')
            ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
            ->join('m_produk', 'r_t_detail_m_produk_id', 'm_produk_id')
            ->join('users', function ($join) {
                $join->on('users_id', '=', DB::raw('CAST(r_t_member_id AS bigint)'))
                    ->whereRaw('LENGTH(r_t_member_id) = 5');
            })
            ->where('m_produk_m_jenis_produk_id', '11');

        if ($request->area != 'all') {
            $wbdWaroengB->where('r_t_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $wbdWaroengB->where('r_t_m_w_id', $request->waroeng);
            }
        }

        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $wbdWaroengB->whereBetween('r_t_tanggal', [$start, $end]);
        } else {
            $wbdWaroengB->where('r_t_tanggal', $request->tanggal);
        }

        $wbdWaroengB->selectRaw('r_t_tanggal as tanggal,
                r_t_m_area_nama as area,
                r_t_m_w_nama as waroeng,
                r_t_m_w_id as waroeng_id,
                sum(r_t_detail_reguler_price * r_t_detail_qty) as nominal_member
            ')
            ->groupBy('tanggal', 'area', 'waroeng', 'r_t_m_w_id')
            ->orderBy('tanggal', 'ASC');

        $wbdWaroengA = $wbdWaroengA->get();
        $wbdWaroengB = $wbdWaroengB->get();

        $member = 0;
        $data = array();
        foreach ($wbdWaroengA as $waroeng) {
            $row = array();
            $row[] = $waroeng->area;
            $row[] = $waroeng->waroeng;
            $row[] = $waroeng->tanggal;
            $row[] = number_format($waroeng->nominal_total);
            foreach ($wbdWaroengB as $waroengB) {
                if ($waroeng->waroeng == $waroengB->waroeng && $waroeng->tanggal == $waroengB->tanggal) {
                    $member = $waroengB->nominal_member;
                }
            }
            $row[] = number_format($member);
            $row[] = '<a id="button_detail_waroeng" class="btn btn-sm button_detail_waroeng btn-info" data-tanggal="' . $waroeng->tanggal . '" data-waroeng="' . $waroeng->waroeng_id . '" title="Detail WBD Omset"><i class="fas fa-eye"></i></a>
            <a id="button_detail_member" class="btn btn-sm button_detail_member btn-warning" data-tanggal="' . $waroeng->tanggal . '" data-waroeng="' . $waroeng->waroeng_id . '" title="Detail WBD karyawan"><i class="fas fa-eye"></i></a>';
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }

    public function detail_waroeng($tanggal, $waroeng)
    {
        $detailWaroeng = DB::table('rekap_transaksi_detail')
            ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
            ->join('m_produk', 'r_t_detail_m_produk_id', 'm_produk_id')
            ->selectRaw('r_t_nota_code as nota,
                    r_t_detail_m_produk_nama as produk,
                    sum(r_t_detail_qty) as qty,
                    r_t_detail_reguler_price as harga,
                    sum(r_t_detail_reguler_price * r_t_detail_qty) as nominal_wbd
                ')
            ->where('r_t_tanggal', $tanggal)
            ->where('r_t_m_w_id', $waroeng)
            ->where('m_produk_m_jenis_produk_id', '11')
            ->groupBy('nota', 'produk', 'harga')
            ->orderby('produk', 'ASC')
            ->get();

        $tgl = DB::table('rekap_transaksi')
            ->select('r_t_tanggal as tanggal')
            ->where('r_t_tanggal', $tanggal)
            ->where('r_t_m_w_id', $waroeng)
            ->first();

        $wrg = DB::table('rekap_transaksi')
            ->select('r_t_m_w_nama as waroeng')
            ->where('r_t_tanggal', $tanggal)
            ->where('r_t_m_w_id', $waroeng)
            ->first();

        $data = array();
        foreach ($detailWaroeng as $waroeng) {
            $row = array();
            $row[] = '<div class="text-center">' . $waroeng->nota . '</div>';
            $row[] = $waroeng->produk;
            $row[] = '<div class="text-center">' . $waroeng->qty . '</div>';
            $row[] = '<div class="text-center">' . number_format($waroeng->harga) . '</div>';
            $row[] = '<div class="text-center">' . number_format($waroeng->nominal_wbd) . '</div>';
            $data[] = $row;
        }

        $output = array(
            "data" => $data,
            "tanggal" => $tgl,
            "waroeng" => $wrg,
        );
        return response()->json($output);
    }

    public function detail_waroeng_member($tanggal, $waroeng)
    {
        $detailWaroeng = DB::table('rekap_transaksi_detail')
            ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
            ->join('m_produk', 'r_t_detail_m_produk_id', 'm_produk_id')
            ->selectRaw('r_t_nota_code as nota,
                    r_t_detail_m_produk_nama as produk,
                    name as member,
                    sum(r_t_detail_qty) as qty,
                    r_t_detail_reguler_price as harga,
                    sum(r_t_detail_reguler_price * r_t_detail_qty) as nominal_wbd
                ')
            ->join('users', function ($join) {
                $join->on('users_id', '=', DB::raw('CAST(r_t_member_id AS bigint)'))
                    ->whereRaw('LENGTH(r_t_member_id) = 5');
            })
            ->where('r_t_tanggal', $tanggal)
            ->where('r_t_m_w_id', $waroeng)
            ->where('m_produk_m_jenis_produk_id', '11')
            ->groupBy('nota', 'produk', 'harga', 'member')
            ->orderby('member', 'ASC')
            ->orderby('produk', 'ASC')
            ->get();

        $tgl = DB::table('rekap_transaksi')
            ->select('r_t_tanggal as tanggal')
            ->where('r_t_tanggal', $tanggal)
            ->where('r_t_m_w_id', $waroeng)
            ->first();

        $wrg = DB::table('rekap_transaksi')
            ->select('r_t_m_w_nama as waroeng')
            ->where('r_t_tanggal', $tanggal)
            ->where('r_t_m_w_id', $waroeng)
            ->first();

        $total = 0;
        $data = array();
        foreach ($detailWaroeng as $waroeng) {
            $row = array();
            $row[] = '<div class="text-center">' . $waroeng->member . '</div>';
            $row[] = '<div class="text-center">' . $waroeng->nota . '</div>';
            $row[] = $waroeng->produk;
            $row[] = '<div class="text-center">' . $waroeng->qty . '</div>';
            $row[] = '<div class="text-center">' . number_format($waroeng->harga) . '</div>';
            $row[] = '<div class="text-center">' . number_format($waroeng->nominal_wbd) . '</div>';
            $data[] = $row;
            $total += $waroeng->nominal_wbd;
        }
        $totalRow = array();
        $totalRow[] = '';
        $totalRow[] = '';
        $totalRow[] = '<div class="text-center"><b> Total </b></div>';
        $totalRow[] = '';
        $totalRow[] = '';
        $totalRow[] = '<div class="text-center"><b>' . number_format($total) . '</b></div>';
        $data[] = $totalRow;

        $output = array(
            "data" => $data,
            "tanggal" => $tgl,
            "waroeng" => $wrg,
        );
        return response()->json($output);
    }
}
