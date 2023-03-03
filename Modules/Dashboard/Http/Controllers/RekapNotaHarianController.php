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
                ->join('rekap_transaksi', 'r_t_id', 'r_p_t_r_t_id');
        if($request->area != 0) {
            $trans->where('r_t_m_area_id', $request->area);
            if($request->waroeng != 'all') {
                $trans->where('r_t_m_w_id', $request->waroeng);
            }
        }
        $trans1 = $trans->whereBetween('r_t_tanggal', $dates)
                ->select('r_t_tanggal')
                ->groupBy('r_t_tanggal')
                ->orderBy('r_t_tanggal', 'ASC')
                ->get();     

        $trans2 = $trans->whereBetween('r_t_tanggal', $dates)
        ->selectRaw('r_p_t_m_payment_method_id, r_t_tanggal, SUM(r_t_nominal) as nominal')
                        ->groupBy('r_t_tanggal', 'r_p_t_m_payment_method_id')
                        ->orderBy('r_p_t_m_payment_method_id', 'ASC')
                        ->get();

        $data = array();
        $i = 1;
        foreach ($trans1 as $key => $valTrans){
            $data[$i]['tanggal'] = $valTrans->r_t_tanggal;
            foreach ($methodPay as $key => $valPay) {
                $data[$i][$valPay->m_payment_method_name] = 0;
                foreach ($trans2 as $key => $valTrans2){
                    if ($valTrans->r_t_tanggal == $valTrans2->r_t_tanggal && $valPay->m_payment_method_id ==                    $valTrans2->r_p_t_m_payment_method_id) {
                        $data[$i][$valPay->m_payment_method_name] = $valTrans2->nominal;
                        $row[] = $data;
                    } 
                }
            }
            
            $i++; 
        }
       
        $output = array("data" => $row);
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
