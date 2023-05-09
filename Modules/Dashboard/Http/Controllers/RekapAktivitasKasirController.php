<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;

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
        $data->akses_area = $this->get_akses_area();//mulai dari 1 - akhir
        $data->akses_pusat = $this->get_akses_pusat();//1,2,3,4,5
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
        }
        return response()->json($data);
    }

    public function select_user(Request $request)
    {
        $user = DB::table('users')
            ->join('rekap_buka_laci', 'r_b_l_created_by', 'users_id')
            ->select('users_id', 'name');
            if(in_array(Auth::user()->waroeng_id, $this->get_akses_area())){
                $user->where('waroeng_id', $request->id_waroeng);
            } else {
                $user->where('waroeng_id', Auth::user()->waroeng_id);
            }
            if (strpos($request->tanggal, 'to') !== false) {
                [$start, $end] = explode('to' ,$request->tanggal);
                    $user->orWhereBetween('r_b_l_tanggal', [$start, $end]);
            } else {
                    $user->orWhere('r_b_l_tanggal', $request->tanggal);
            }
            $user = $user->orderBy('users_id', 'asc')
            ->get();
        $data = array();
        foreach ($user as $val) {
            $data[$val->users_id] = [$val->name];
            $data['all'] = 'All Operator';
        }
        return response()->json($data);
    }

    public function show(Request $request)
    {
        $buka_laci = DB::table('rekap_buka_laci')
            ->join('users', 'users_id', 'r_b_l_created_by')
            ->selectRaw('r_b_l_rekap_modal_id, r_b_l_tanggal, name, sum(r_b_l_qty) as laci');
            if (strpos($request->tanggal, 'to') !== false) {
                [$start, $end] = explode('to', $request->tanggal);
                $buka_laci->whereBetween('r_b_l_tanggal', [$start, $end]);
            } else {
                $buka_laci->where('r_b_l_tanggal', $request->tanggal);
            }
            if($request->operator != 'all'){
                $buka_laci->where('r_b_l_created_by', $request->operator);
            }
            $buka_laci = $buka_laci->groupby('r_b_l_tanggal', 'name', 'r_b_l_rekap_modal_id')
                ->orderby('r_b_l_tanggal', 'ASC')
                ->get();
        
        $data = array();
        foreach ($buka_laci as $laci){
            $row = array();
            $row[] = date('d-m-Y', strtotime($laci->r_b_l_tanggal));
            // $row[] = date('d-m-Y H:i', strtotime($laci->r_b_l_tanggal));
            $row[] = $laci->name;
            $row[] = $laci->laci;
            $row[] ='<a id="button_detail" class="btn btn-sm button_detail btn-info" value="'.$laci->r_b_l_rekap_modal_id.'" title="Detail Nota"><i class="fa-sharp fa-solid fa-eye"></i></a>';
            $data[] = $row;
        }

        $output = array("data" => $data);
        return response()->json($output);
    }

    public function rekap_hps_menu()
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass();
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama', 'm_w_id')->where('m_w_id', $waroeng_id)->first();
        $data->area_nama = DB::table('m_area')->join('m_w', 'm_w_m_area_id', 'm_area_id')->select('m_area_nama', 'm_area_id')->where('m_w_id', $waroeng_id)->first();
        $data->akses_area = $this->get_akses_area();//mulai dari 1 - akhir
        $data->akses_pusat = $this->get_akses_pusat();//1,2,3,4,5
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
    public function rekap_hps_nota()
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass();
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama', 'm_w_id')->where('m_w_id', $waroeng_id)->first();
        $data->area_nama = DB::table('m_area')->join('m_w', 'm_w_m_area_id', 'm_area_id')->select('m_area_nama', 'm_area_id')->where('m_w_id', $waroeng_id)->first();
        $data->akses_area = $this->get_akses_area();//mulai dari 1 - akhir
        $data->akses_pusat = $this->get_akses_pusat();//1,2,3,4,5
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
}
