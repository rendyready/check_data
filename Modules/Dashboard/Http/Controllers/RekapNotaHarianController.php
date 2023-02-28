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
            $data['all'] = ['all waroeng'];
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
        $methodPay = DB::table('m_payment_method')
                ->orderBy('m_payment_method_id', 'ASC')
                ->get();
        $trans = DB::table('rekap_payment_transaksi')
                ->join('rekap_transaksi', 'r_t_id', 'r_p_t_r_t_id')
                ->selectRaw('r_p_t_m_payment_method_id, r_t_tanggal, SUM(r_t_nominal) as nominal');
                if($request->area != 0) {
                    $get->where('r_t_m_area_id', $request->area);
                    if($request->waroeng != 'all') {
                        $get->where('r_t_m_w_id', $request->waroeng);
                    }
                }
        $trans2 = $trans->whereBetween('r_t_tanggal', $dates)
                        ->groupBy('r_t_tanggal', 'r_p_t_m_payment_method_id')
                        ->orderBy('r_p_t_m_payment_method_id', 'ASC')
                        ->get();

    $data = array();
        foreach ($trans2 as $key => $valTrans){
            foreach ($methodPay as $key => $valPay) {
                $data[$valTrans->r_t_tanggal]['tanggal'] = $valTrans->r_t_tanggal;
                if($valPay->m_payment_method_id == $valTrans->r_p_t_m_payment_method_id){
                    $data[$valTrans->r_t_tanggal][$valPay->m_payment_method_name] = $valTrans->nominal;
                } else {
                    $data[$valTrans->r_t_tanggal][$valPay->m_payment_method_name] = 0;
                }
            }
        }

        // for ($i=1; $i < $methodPay+1; $i++) { 
        //     foreach ($trans as $key => $valTrans){
        //                 $data[$valTrans->r_t_tanggal]['tanggal'] = $valTrans->r_t_tanggal;
                        // if($valTrans->r_p_t_m_payment_method_id == $i){
                            // $data[$valTrans->r_t_tanggal][$i] = $valTrans->nominal;
                        // } else {
                        //     $data[$valTrans->r_t_tanggal][$i] = 0;
                        // }
            //     }
            // }

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
