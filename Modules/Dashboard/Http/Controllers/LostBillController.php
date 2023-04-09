<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;

class LostBillController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
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
        $data->user = DB::table('users')
            ->orderby('id', 'ASC')
            ->get();
        $data->transaksi_rekap = DB::table('rekap_lost_bill')
            ->get();
        return view('dashboard::rekap_lostbill', compact('data'));
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
            ->join('rekap_lost_bill', 'r_l_b_created_by', 'users_id')
            ->select('users_id', 'name');
            if(in_array(Auth::user()->waroeng_id, $this->get_akses_area())){
                $user->where('waroeng_id', $request->id_waroeng);
            } else {
                $user->where('waroeng_id', Auth::user()->waroeng_id);
            }
            if (strpos($request->tanggal, 'to') !== false) {
                [$start, $end] = explode('to' ,$request->tanggal);
                $user->whereBetween('r_l_b_tanggal', [$start, $end]);
            } else {
                $user->where('r_l_b_tanggal', $request->tanggal);
            }
            $user1 = $user->orderBy('users_id', 'asc')
            ->get();
        $data = array();
        foreach ($user1 as $val) {
            $data[$val->users_id] = [$val->name];
            $data['all'] = 'All Operator';
        }
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Request $request)
    {
        $get2 = DB::table('rekap_lost_bill')
                ->join('users', 'users_id', 'r_l_b_created_by')
                ->where('r_l_b_m_w_id', $request->waroeng);
                if (strpos($request->tanggal, 'to') !== false) {
                    $dates = explode('to' ,$request->tanggal);
                    $get2->whereBetween('r_l_b_tanggal', $dates);
                } else {
                    $get2->where('r_l_b_tanggal', $request->tanggal);
                }
                if($request->operator != 'all'){
                    $get2->where('r_l_b_created_by', $request->operator);
                }
                $get = $get2->orderBy('r_l_b_tanggal', 'ASC')
                ->orderBy('r_l_b_nota_code', 'ASC')
                ->get();
        
        $data = array();
        foreach ($get as $value) {
            $row = array();
            $row[] = date('d-m-Y', strtotime($value->r_l_b_tanggal));
            $row[] = $value->r_l_b_jam;
            $row[] = $value->name;
            $row[] = $value->r_l_b_bigboss;
            $row[] = $value->name;
            $row[] = $value->r_l_b_nota_code;
            $row[] = number_format($value->r_l_b_nominal);
            $row[] = number_format($value->r_l_b_nominal_pajak);
            $row[] = number_format($value->r_l_b_nominal_sc);
            $row[] = number_format($value->r_l_b_nominal + $value->r_l_b_nominal_pajak + $value->r_l_b_nominal_sc);
            $row[] ='<a id="button_detail" class="btn btn-sm button_detail btn-info" value="'.$value->r_l_b_id.'" title="Detail Lost Bill"><i class="fa-sharp fa-solid fa-file"></i></a>';
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }

    public function detail($id)
    {
        $data = new \stdClass();
        $data->transaksi_rekap = DB::table('rekap_lost_bill')
                ->join('users', 'users_id', 'r_l_b_created_by')
                ->where('r_l_b_id', $id)
                ->first();
        $data->detail_nota = DB::table('rekap_lost_bill_detail')
            ->where('r_l_b_detail_r_l_b_id', $id)
            ->get();
        return response()->json($data);
    }

    public function edit($id)
    {
        return view('dashboard::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
