<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;

class RekapPenjualanKategoriMenuController extends Controller
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
        $data->payment = DB::table('m_jenis_produk')
            ->orderby('id', 'ASC')
            ->get();
        return view('dashboard::rekap_penj_kategori_menu', compact('data'));
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
            ->select('users_id', 'name')
            ->where('waroeng_id', $request->id_waroeng)
            ->orderBy('users_id', 'asc')
            ->get();
        $data = array();
        foreach ($user as $val) {
            $data[$val->users_id] = [$val->name];
        }
        return response()->json($data);
    }

    
    public function show(Request $request)
    {
        $methodPay = DB::table('m_jenis_produk')
                ->orderBy('m_jenis_produk_id', 'ASC')
                ->get();
        if (strpos($request->tanggal, 'to') !== false) {
            $dates = explode('to' ,$request->tanggal);
            if($request->show_operator == 'ya'){
                $trans = DB::table('rekap_transaksi')
                    ->where('r_t_created_by', $request->operator)
                    ->where('r_t_m_area_id', $request->area)
                    ->where('r_t_m_w_id', $request->waroeng);

                $trans1 = $trans->whereBetween('r_t_tanggal', $dates)
                    ->join('users', 'users_id', 'r_t_created_by')
                    ->join('m_area', 'm_area_code', 'r_t_m_area_code')
                    ->join('m_w', 'm_w_code', 'r_t_m_w_code')
                    ->select('r_t_tanggal', 'name', 'm_area_nama', 'm_w_nama')
                    ->groupBy('r_t_tanggal', 'name', 'm_area_nama', 'm_w_nama')
                    ->orderBy('r_t_tanggal', 'ASC')
                    ->get(); 

            } else {
                if($request->area == '0'){
                    $trans = DB::table('rekap_transaksi');
                } else {
                    $trans = DB::table('rekap_transaksi')
                            ->where('r_t_m_area_id', $request->area);
                                if($request->waroeng != 'all') {
                                    $trans->where('r_t_m_w_id', $request->waroeng);
                                }
                }
                $trans1 = $trans->whereBetween('r_t_tanggal', $dates)
                ->join('m_area', 'm_area_code', 'r_t_m_area_code')
                ->join('m_w', 'm_w_code', 'r_t_m_w_code')
                ->select('r_t_tanggal',  'm_area_nama', 'm_w_nama')            
                ->groupBy('r_t_tanggal', 'm_area_nama', 'm_w_nama')
                ->orderBy('r_t_tanggal', 'ASC')
                ->get(); 
            }
            
        $trans2 = $trans->whereBetween('r_t_tanggal', $dates)
                ->join('rekap_transaksi_detail', 'r_t_detail_r_t_id', 'r_t_id')
                ->join('m_produk', 'm_produk_id', 'r_t_detail_m_produk_id')
                ->selectRaw('m_produk_m_jenis_produk_id, r_t_tanggal, (r_t_detail_reguler_price * SUM(r_t_detail_qty)) as total')
                ->groupBy('r_t_tanggal', 'm_produk_m_jenis_produk_id', 'r_t_detail_reguler_price')
                ->orderBy('m_produk_m_jenis_produk_id', 'ASC')
                ->get();
    } else {
        $dates = explode('to' ,$request->tanggal);
        if($request->show_operator == 'ya'){
            $trans = DB::table('rekap_transaksi')
                ->where('r_t_created_by', $request->operator)
                ->where('r_t_m_area_id', $request->area)
                ->where('r_t_m_w_id', $request->waroeng);

            $trans1 = $trans->where('r_t_tanggal', $request->tanggal)
                ->join('users', 'users_id', 'r_t_created_by')
                ->join('m_area', 'm_area_code', 'r_t_m_area_code')
                ->join('m_w', 'm_w_code', 'r_t_m_w_code')
                ->select('r_t_tanggal', 'name', 'm_area_nama', 'm_w_nama')
                ->groupBy('r_t_tanggal', 'name', 'm_area_nama', 'm_w_nama')
                ->orderBy('r_t_tanggal', 'ASC')
                ->get(); 

        } else {
            if($request->area == '0'){
                $trans = DB::table('rekap_transaksi');
            } else {
                $trans = DB::table('rekap_transaksi')
                        ->where('r_t_m_area_id', $request->area);
                            if($request->waroeng != 'all') {
                                $trans->where('r_t_m_w_id', $request->waroeng);
                            }
            }
            $trans1 = $trans->where('r_t_tanggal', $request->tanggal)
            ->join('m_area', 'm_area_code', 'r_t_m_area_code')
            ->join('m_w', 'm_w_code', 'r_t_m_w_code')
            ->select('r_t_tanggal',  'm_area_nama', 'm_w_nama')            
            ->groupBy('r_t_tanggal', 'm_area_nama', 'm_w_nama')
            ->orderBy('r_t_tanggal', 'ASC')
            ->get(); 
        }
        
        $trans2 = $trans->where('r_t_tanggal', $request->tanggal)
                ->join('rekap_transaksi_detail', 'r_t_detail_r_t_id', 'r_t_id')
                ->join('m_produk', 'm_produk_id', 'r_t_detail_m_produk_id')
                ->selectRaw('m_produk_m_jenis_produk_id, r_t_tanggal, (r_t_detail_reguler_price * SUM(r_t_detail_qty)) as total')
                ->groupBy('r_t_tanggal', 'm_produk_m_jenis_produk_id', 'r_t_detail_reguler_price')
                ->orderBy('m_produk_m_jenis_produk_id', 'ASC')
                ->get();
    }

    $data =[];
    if($request->show_operator == 'ya'){
            $i =1;
            foreach ($trans1 as $key => $valTrans) {
                $data[$i]['area'] = $valTrans->m_area_nama;
                $data[$i]['waroeng'] = $valTrans->m_w_nama;
                $data[$i]['tanggal'] = date('d-m-Y', strtotime($valTrans->r_t_tanggal));
                $data[$i]['operator'] = $valTrans->name;
                foreach ($methodPay as $key => $valPay) {
                    $total = 0;
                    foreach ($trans2 as $key2 => $valTrans2) {
                        if ($valPay->m_jenis_produk_id == $valTrans2->m_produk_m_jenis_produk_id) {
                            $total += $valTrans2->total;
                        }
                    }
                    $data[$i][$valPay->m_jenis_produk_nama] = rupiah($total, 0);
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
            $data[$i]['tanggal'] = date('d-m-Y', strtotime($valTrans->r_t_tanggal));
            foreach ($methodPay as $key => $valPay) {
                $total = 0;
                foreach ($trans2 as $key2 => $valTrans2) {
                    if ($valPay->m_jenis_produk_id == $valTrans2->m_produk_m_jenis_produk_id) {
                        $total += $valTrans2->total;
                    }
                }
                $data[$i][$valPay->m_jenis_produk_nama] = rupiah($total, 0);
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
