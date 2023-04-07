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

    public function select_user(Request $request)
    {
        $user = DB::table('users')
            ->join('rekap_transaksi', 'r_t_created_by', 'users_id')
            ->select('users_id', 'name')
            ->where('waroeng_id', $request->id_waroeng);
            if (strpos($request->tanggal, 'to') !== false) {
                [$start, $end] = explode('to' ,$request->tanggal);
                $user->whereBetween('r_t_tanggal', [$start, $end]);
            } else {
                $user->where('r_t_tanggal', $request->tanggal);
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

    public function show(Request $request)
    {
        $methodPay = DB::table('m_payment_method')
            ->orderBy('m_payment_method_id', 'ASC')
            ->get();
        
        $trans = DB::table('rekap_payment_transaksi')
                ->join('rekap_transaksi', 'r_t_id', 'r_p_t_r_t_id')
                ->join('m_area', 'm_area_code', 'r_t_m_area_code')
                ->join('m_w', 'm_w_code', 'r_t_m_w_code');
            if($request->area != '0'){
                $trans->where('r_t_m_area_id', $request->area);
                if($request->waroeng != 'all') {
                    $trans->where('r_t_m_w_id', $request->waroeng);
                }
            }
            if($request->show_operator == 'ya'){
                $trans->where('r_t_created_by', $request->operator);
            }
            if (strpos($request->tanggal, 'to') !== false) {
                $dates = explode('to' ,$request->tanggal);
                $trans->whereBetween('r_t_tanggal', $dates);
            } else {
                $trans->where('r_t_tanggal', $request->tanggal);
            }
                if($request->show_operator == 'ya'){
                    $trans->join('users', 'users_id', 'r_t_created_by')
                    ->selectRaw('r_t_tanggal, SUM(r_t_nominal_total_bayar) as total, SUM(r_t_nominal_pembulatan) as pembulatan, SUM(r_t_nominal_free_kembalian) as free, name, m_area_nama, m_w_nama')
                    ->groupBy('r_t_tanggal', 'name', 'm_area_nama', 'm_w_nama');
                } else {
                     $trans->selectRaw('r_t_tanggal, SUM(r_t_nominal_total_bayar) as total, SUM(r_t_nominal_pembulatan) as pembulatan, SUM(r_t_nominal_free_kembalian) as free, m_area_nama, m_w_nama')
                    ->groupBy('r_t_tanggal', 'm_area_nama', 'm_w_nama');
                }
                $trans1 = $trans->orderBy('r_t_tanggal', 'ASC')
                ->get();  
            
            $trans->selectRaw('r_p_t_m_payment_method_id, r_t_tanggal, SUM(r_t_nominal_total_bayar) as nominal, SUM(r_t_nominal_pembulatan) as bulat, SUM(r_t_nominal_free_kembalian) as kembali');
            if (strpos($request->tanggal, 'to') !== false) {
                $dates = explode('to' ,$request->tanggal);
                $trans->whereBetween('r_t_tanggal', $dates);
            } else {
                $trans->where('r_t_tanggal', $request->tanggal);
            }
            $trans2 = $trans->groupBy('r_t_tanggal', 'r_p_t_m_payment_method_id')
                ->orderBy('r_p_t_m_payment_method_id', 'ASC')
                ->get();
        
        $data =[];
            $i =1;
            foreach ($trans1 as $key => $valTrans){
                $data[$i]['area'] = $valTrans->m_area_nama;
                $data[$i]['waroeng'] = $valTrans->m_w_nama;
                $data[$i]['tanggal'] = date('d-m-Y', strtotime($valTrans->r_t_tanggal));
                if($request->show_operator == 'ya'){
                $data[$i]['operator'] = $valTrans->name;
                }
                $data[$i]['penjualan'] = number_format($valTrans->total - ($valTrans->pembulatan + $valTrans->free));
                foreach ($methodPay as $key => $valPay) {
                    $data[$i][$valPay->m_payment_method_name] = 0;
                    foreach ($trans2 as $key => $valTrans2){
                            if ($valTrans->r_t_tanggal == $valTrans2->r_t_tanggal && $valPay->m_payment_method_id == $valTrans2->r_p_t_m_payment_method_id) {
                                $data[$i][$valPay->m_payment_method_name] = number_format($valTrans2->nominal - ($valTrans2->bulat + $valTrans2->kembali));
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
