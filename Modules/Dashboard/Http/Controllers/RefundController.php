<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;

class RefundController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = new \stdClass();
        $data->waroeng = DB::table('m_w')
            ->orderby('m_w_id', 'ASC')
            ->get();
        $data->area = DB::table('m_area')
            ->orderby('m_area_id', 'ASC')
            ->get();
        $data->user = DB::table('users')
            ->orderby('id', 'ASC')
            ->get();
        $data->transaksi_rekap = DB::table('rekap_refund')
            ->get();
        return view('dashboard::rekap_refund', compact('data'));
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
            ->select('users_id', 'name')
            ->where('waroeng_id', $request->id_waroeng)
            ->orderBy('users_id', 'asc')
            ->get();
        $data = array();
        foreach ($user as $val) {
            $data[$val->users_id] = [$val->name];
            $data['all'] = 'All Operator';
        }
        return response()->json($data);
    }

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
        if (strpos($request->tanggal, 'to') !== false) {
        $dates = explode('to' ,$request->tanggal);
        $get2 = DB::table('rekap_refund')
                ->join('users', 'users_id', 'r_r_created_by')
                ->join('rekap_transaksi', 'r_t_id', 'r_r_r_t_id')
                ->where('r_r_m_w_id', $request->waroeng)
                ->whereBetween('r_r_tanggal', $dates);
                    if($request->operator != 'all'){
                        $get2->where('r_r_created_by', $request->operator);
                    }
                $get = $get2->orderBy('r_r_tanggal', 'ASC')
                ->orderBy('r_r_nota_code', 'ASC')
                ->get();
        } else {
        $get2 = DB::table('rekap_refund')
            ->join('users', 'users_id', 'r_r_created_by')
            ->join('rekap_transaksi', 'r_t_id', 'r_r_r_t_id')
            ->where('r_r_m_w_id', $request->waroeng)
            ->where('r_r_tanggal', $request->tanggal);
                if($request->operator != 'all'){
                    $get2->where('r_r_created_by', $request->operator);
                }
            $get = $get2->orderBy('r_r_tanggal', 'ASC')
            ->orderBy('r_r_nota_code', 'ASC')
            ->get();
        }
        $data = array();
        foreach ($get as $value) {
            $row = array();
            $row[] = date('d-m-Y', strtotime($value->r_t_tanggal));
            $row[] = date('d-m-Y', strtotime($value->r_r_tanggal));
            $row[] = $value->name;
            $row[] = $value->name;
            $row[] = $value->r_r_bigboss;
            $row[] = $value->r_r_nota_code;
            $row[] = number_format($value->r_t_nominal);
            $row[] = number_format($value->r_r_nominal_refund);
            $row[] = number_format($value->r_t_nominal_pajak, 0);
            $row[] = number_format($value->r_r_nominal_refund_pajak);
            $row[] = number_format($value->r_t_nominal_sc);
            $row[] = number_format($value->r_r_nominal_refund_sc);
            $row[] = number_format($value->r_t_nominal_pembulatan);
            $row[] = number_format($value->r_r_nominal_pembulatan_refund);
            $row[] = number_format($value->r_t_nominal_free_kembalian);
            $row[] = number_format($value->r_r_nominal_free_kembalian_refund);
            $row[] = number_format($value->r_t_nominal_total_bayar);
            $row[] = number_format($value->r_r_nominal_refund_total);
            $row[] = number_format($value->r_t_nominal_total_bayar - $value->r_r_nominal_refund_total);
            $row[] ='<a id="button_detail" class="btn btn-sm button_detail btn-info" value="'.$value->r_r_id.'" title="Detail Refund"><i class="fa-sharp fa-solid fa-file"></i></a>';
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }

    public function detail($id)
    {
        $data = new \stdClass();
        $data->transaksi_rekap = DB::table('rekap_refund')
                ->join('users', 'users_id', 'r_r_created_by')
                ->where('r_r_id', $id)
                ->first();
        $data->detail_nota = DB::table('rekap_refund_detail')
            ->where('r_r_detail_r_r_id', $id)
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
