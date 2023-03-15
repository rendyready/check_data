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
        // $data->user = DB::table('users')
        //     ->orderby('id', 'ASC')
        //     ->get();
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

    public function select_operator(Request $request)
    {
        $operator = DB::table('users')
            ->where('waroeng_id', $request->id_waroeng)
            ->orderBy('users_id', 'asc')
            ->get();
        $data = array();
        foreach ($operator as $val) {
            $data[$val->users_id] = [$val->name];
            // $data['all'] = ['all operator'];

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

    public function show(Request $request)
    {
        $dates = explode('to' ,$request->tanggal);
        $refund = DB::table('rekap_refund')->get();
        $methodPay = DB::table('m_payment_method')
                ->orderBy('m_payment_method_id', 'ASC')
                ->get();
        if($request->show_operator == 'ya'){
            if($request->area == '0'){
                $trans = DB::table('rekap_payment_transaksi')
                ->join('rekap_transaksi', 'r_t_id', 'r_p_t_r_t_id');
                if($request->operator != 'all'){
                    $trans->where('r_t_created_by', $request->operator);
                }
            } else {
                $trans2 = DB::table('rekap_payment_transaksi')
                        ->join('rekap_transaksi', 'r_t_id', 'r_p_t_r_t_id');
                        if($request->operator != 'all'){
                            $trans2->where('r_t_created_by', $request->operator);
                        }
                        $trans = $trans2->where('r_t_m_area_id', $request->area)
                        ->where('r_t_m_w_id', $request->waroeng);
            }
        } else {
            if($request->area == '0'){
                $trans = DB::table('rekap_payment_transaksi')
                ->join('rekap_transaksi', 'r_t_id', 'r_p_t_r_t_id');
            } else {
                $trans = DB::table('rekap_payment_transaksi')
                        ->join('rekap_transaksi', 'r_t_id', 'r_p_t_r_t_id')
                        ->where('r_t_m_area_id', $request->area);
                            if($request->waroeng != 'all') {
                                $trans->where('r_t_m_w_id', $request->waroeng);
                            }
            }
        }
        
        $trans1 = $trans->whereBetween('r_t_tanggal', $dates)
                ->join('users', 'users_id', 'r_t_created_by')
                ->join('m_area', 'm_area_code', 'r_t_m_area_code')
                ->join('m_w', 'm_w_code', 'r_t_m_w_code')
                ->selectRaw('r_t_tanggal, SUM(r_t_nominal) as total, name, m_area_nama, m_w_nama')
                ->groupBy('r_t_tanggal', 'name', 'm_area_nama', 'm_w_nama')
                ->orderBy('r_t_tanggal', 'ASC')
                ->get();  

        $trans2 = $trans->whereBetween('r_t_tanggal', $dates)
                ->selectRaw('r_p_t_m_payment_method_id, r_t_tanggal, SUM(r_t_nominal) as nominal')
                        ->groupBy('r_t_tanggal', 'r_p_t_m_payment_method_id')
                        ->orderBy('r_p_t_m_payment_method_id', 'ASC')
                        ->get();

        $data =[];
        
        if($request->show_operator == 'ya'){
            $i =1;
            foreach ($trans1 as $key => $valTrans){
                $data[$i]['area'] = $valTrans->m_area_nama;
                $data[$i]['waroeng'] = $valTrans->m_w_nama;
                $data[$i]['tanggal'] = $valTrans->r_t_tanggal;
                $data[$i]['operator'] = $valTrans->name;
                foreach ($refund as $key => $valRefund){
                    if ($valRefund->r_r_tanggal == $valTrans->r_t_tanggal) {
                         $data[$i]['penjualan'] = rupiah($valTrans->total - $valRefund->r_r_nominal_refund, 0);
                    } else {
                        $data[$i]['penjualan'] = rupiah($valTrans->total, 0);
                    }
                foreach ($methodPay as $key => $valPay) {
                    $data[$i][$valPay->m_payment_method_name] = 0;
                    foreach ($trans2 as $key => $valTrans2){
                            if ($valTrans->r_t_tanggal == $valTrans2->r_t_tanggal && $valPay->m_payment_method_id == $valTrans2->r_p_t_m_payment_method_id) {
                                $data[$i][$valPay->m_payment_method_name] = rupiah($valTrans2->nominal, 0);
                            } 
                    }
                    } 
                }
                $i++; 
            }
            $length = count($data);
            $convert = array();
            for ($i=1; $i <= $length ; $i++) { 
                array_push($convert,array_values($data[$i]));
            }
    } else {
        $i =1;
        foreach ($trans1 as $key => $valTrans){
            $data[$i]['area'] = $valTrans->m_area_nama;
            $data[$i]['waroeng'] = $valTrans->m_w_nama;
            $data[$i]['tanggal'] = $valTrans->r_t_tanggal;
            foreach ($refund as $key => $valRefund){
                if ($valRefund->r_r_tanggal == $valTrans->r_t_tanggal) {
                     $data[$i]['penjualan'] = rupiah($valTrans->total - $valRefund->r_r_nominal_refund, 0);
                } else {
                    $data[$i]['penjualan'] = rupiah($valTrans->total, 0);
                }
            foreach ($methodPay as $key => $valPay) {
                $data[$i][$valPay->m_payment_method_name] = 0;
                foreach ($trans2 as $key => $valTrans2){
                        if ($valTrans->r_t_tanggal == $valTrans2->r_t_tanggal && $valPay->m_payment_method_id == $valTrans2->r_p_t_m_payment_method_id) {
                            $data[$i][$valPay->m_payment_method_name] = rupiah($valTrans2->nominal, 0);
                        } 
                }
                } 
            }
            $i++; 
        }
        $length = count($data);
        $convert = array();
        for ($i=1; $i <= $length ; $i++) { 
            array_push($convert,array_values($data[$i]));
        }
    }
        $output = array("data" => $convert);
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
