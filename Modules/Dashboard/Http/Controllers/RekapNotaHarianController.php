<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;

class RekapNotaHarianController extends Controller
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
        $data->payment = DB::table('m_payment_method')
            ->orderby('m_payment_method_id', 'ASC')
            ->get();
        return view('dashboard::rekap_nota_harian', compact('data'));
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

    public function create()
    {
        return view('dashboard::create');
    }

    public function show(Request $request)
    {
        $dates = explode('to' ,$request->tanggal);
        $field = DB::table('rekap_transaksi')
                ->join('rekap_transaksi_detail', 'r_t_detail_r_t_id', 'r_t_id')
                ->join('rekap_payment_transaksi', 'r_p_t_r_t_id', 'r_t_id')
                ->join('m_payment_method', 'm_payment_method_id', 'r_p_t_m_payment_method_id')
                ->select('r_t_tanggal', DB::raw("SUM(r_t_nominal) as total_nota"), DB::raw("SUM(r_p_t_nominal) as total_payment"), 'm_payment_method_type', 'm_payment_method_name')
                ->where('r_t_m_w_id', $request->waroeng)
                ->whereBetween('r_t_tanggal', $dates)
                ->groupBy('r_t_tanggal', 'm_payment_method_type' , 'm_payment_method_name')
                ->orderBy('r_t_tanggal', 'ASC')
                ->get();

        $get = DB::table('rekap_transaksi')
                ->join('rekap_transaksi_detail', 'r_t_detail_r_t_id', 'r_t_id')
                // ->join('rekap_payment_transaksi', 'r_p_t_r_t_id', 'r_t_id')
                // ->join('m_payment_method', 'm_payment_method_id', 'r_p_t_m_payment_method_id')
                // ->select('r_t_tanggal', DB::raw("SUM(r_t_nominal) as total_nota"), DB::raw("SUM(r_p_t_nominal) as total_payment"), 'm_payment_method_type', 'm_payment_method_name')
                ->select('r_t_tanggal', DB::raw("SUM(r_t_nominal) as total_nota"))
                ->where('r_t_m_w_id', $request->waroeng)
                ->whereBetween('r_t_tanggal', $dates)
                ->groupBy('r_t_tanggal')
                // ->groupBy('r_t_tanggal', 'm_payment_method_type' , 'm_payment_method_name')
                ->orderBy('r_t_tanggal', 'ASC')
                ->get();
        $data = array();
        
        foreach ($field as $payment){

         return   $raw[] = $payment->total_payment;

        foreach ($get as $value) {
            $row = array();
            $row[] = date('d-m-Y', strtotime($value->r_t_tanggal));
            $row[] = rupiah($value->total_nota, 0);
            // $row[2] = $raw;
            $data[] = $row;
        }
    }

        $output = array("data" => $data);
        return response()->json($output);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
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
