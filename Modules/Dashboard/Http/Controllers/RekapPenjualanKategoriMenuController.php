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
        
                $trans1 = DB::table('rekap_transaksi')
                    ->join('m_area', 'm_area_code', 'r_t_m_area_code')
                    ->join('m_w', 'm_w_code', 'r_t_m_w_code');
                    if($request->area != 'all'){
                        $trans1->where('r_t_m_area_id', $request->area);
                        if($request->waroeng != 'all') {
                            $trans1->where('r_t_m_w_id', $request->waroeng);
                        }
                    }
                    if($request->show_operator == 'ya'){
                        if($request->operator != 'all'){
                        $trans1->where('r_t_created_by', $request->operator);
                        }
                    }
                    if (strpos($request->tanggal, 'to') !== false) {
                        $dates = explode('to' ,$request->tanggal);
                        $trans1->whereBetween('r_t_tanggal', $dates);
                    } else {
                        $trans1->where('r_t_tanggal', $request->tanggal);
                    }
                    if($request->show_operator == 'ya'){
                        $trans1->join('users', 'users_id', 'r_t_created_by')
                                ->select('r_t_tanggal', 'name', 'm_area_nama', 'm_w_nama')
                                ->groupBy('r_t_tanggal', 'name', 'm_area_nama', 'm_w_nama');
                    } else {
                        $trans1->select('r_t_tanggal', 'm_area_nama', 'm_w_nama')
                                ->groupBy('r_t_tanggal', 'm_area_nama', 'm_w_nama');
                    }
            $trans = $trans1->orderBy('r_t_tanggal', 'ASC')
                    ->get(); 
            
        $trans1->join('rekap_transaksi_detail', 'r_t_detail_r_t_id', 'r_t_id')
                ->join('m_produk', 'm_produk_id', 'r_t_detail_m_produk_id');
                if (strpos($request->tanggal, 'to') !== false) {
                    $dates = explode('to' ,$request->tanggal);
                    $trans1->whereBetween('r_t_tanggal', $dates);
                } else {
                    $trans1->where('r_t_tanggal', $request->tanggal);
                }
        $trans2 = $trans1->selectRaw('m_produk_m_jenis_produk_id, r_t_tanggal, r_t_detail_reguler_price, SUM(r_t_detail_qty) as total')
                ->groupBy('r_t_tanggal', 'm_produk_m_jenis_produk_id', 'r_t_detail_reguler_price')
                ->orderBy('m_produk_m_jenis_produk_id', 'ASC')
                ->get();
        
            $data =[];
            $i =1;
            foreach ($trans as $key => $valTrans) {
                $data[$i]['area'] = $valTrans->m_area_nama;
                $data[$i]['waroeng'] = $valTrans->m_w_nama;
                $data[$i]['tanggal'] = date('d-m-Y', strtotime($valTrans->r_t_tanggal));
                if($request->show_operator == 'ya'){
                $data[$i]['operator'] = $valTrans->name;
                }
                $grandTotal = 0;
                foreach ($methodPay as $key => $valPay) {
                    $total = 0;
                    foreach ($trans2 as $key2 => $valTrans2) {
                        if ($valPay->m_jenis_produk_id == $valTrans2->m_produk_m_jenis_produk_id && $valTrans2->r_t_tanggal == $valTrans->r_t_tanggal) {
                            $total += $valTrans2->total * $valTrans2->r_t_detail_reguler_price;
                        }
                    }
                    $data[$i][$valPay->m_jenis_produk_nama] = number_format($total);
                    $grandTotal += $total;
                }
                $data[$i]['Total'] = number_format($grandTotal);
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

