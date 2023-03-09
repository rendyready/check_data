<?php

namespace Modules\Dashboard\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;

class RekapMenuController extends Controller
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
        $data->tanggal = DB::table('rekap_transaksi')
            ->select('r_t_tanggal')
            ->orderBy('r_t_tanggal', 'asc')
            ->get();
        return view('dashboard::rekap_menu', compact('data'));
    }

    public function tanggal_rekap(Request $request)
    {
        $dates = explode('to' ,$request->tanggal);
        $tanggal = DB::table('rekap_transaksi')
        ->select('r_t_tanggal')
        ->whereBetween('r_t_tanggal', $dates)        
        ->orderBy('r_t_tanggal', 'asc')
        ->get();
        foreach ($tanggal as $val) {
            $data[] = date('d-m-Y', strtotime($val->r_t_tanggal));
        }
        return response()->json($data);
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

    function show(Request $request) {
        $dates = explode('to', $request->tanggal);
        $tanggal = DB::table('rekap_transaksi')
                    ->whereBetween('r_t_tanggal', $dates)
                    ->orderBy('r_t_tanggal', 'ASC')
                    ->get();

            if($request->area == '0'){
                $get = DB::table('rekap_transaksi_detail')
                ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
                ->join('m_area', 'm_area_id', 'r_t_m_area_id')
                ->join('m_w', 'm_w_id', 'r_t_m_w_id')
                ->whereBetween('r_t_tanggal', $dates);
            } else {
            $get = DB::table('rekap_transaksi_detail')
                    ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
                    ->join('m_area', 'm_area_id', 'r_t_m_area_id')
                    ->join('m_w', 'm_w_id', 'r_t_m_w_id')
                    ->whereBetween('r_t_tanggal', $dates)
                    ->where('r_t_m_area_id', $request->area);
                    if ($request->waroeng != 'all') {
                        $get->where('r_t_m_w_id', $request->waroeng);
                    }
            }
            $get1 = $get->select('r_t_detail_m_produk_nama', 'm_w_nama', 'm_area_nama')
                    ->groupBy('r_t_detail_m_produk_nama', 'm_w_nama', 'm_area_nama')
                    ->get();
        $get2 = $get->selectRaw('sum(r_t_detail_qty) as qty, sum(r_t_detail_reguler_price) as nominal, r_t_tanggal, r_t_detail_m_produk_nama, m_w_nama, m_area_nama')
                    ->groupBy('r_t_tanggal', 'r_t_detail_m_produk_nama', 'm_w_nama', 'm_area_nama')
                    ->get();
        $data = [];
         
            foreach ($get2 as $row) {
                $waroeng = $row->m_w_nama;
                $menu = $row->r_t_detail_m_produk_nama;
                $area = $row->m_area_nama;
                $date = $row->r_t_tanggal;
                $qty = $row->qty;
                $nominal = rupiah($row->nominal * $qty, 0);
                if (!isset($data[$waroeng])) {
                    $data[$waroeng] = [];
                }
                if (!isset($data[$waroeng][$menu])) {
                    $data[$waroeng][$menu] = [];
                }
                if (!isset($data[$waroeng][$menu][$area])) {
                    $data[$waroeng][$menu][$area] = [];
                }
                if (!isset($data[$waroeng][$menu][$area][$date])) {
                    $data[$waroeng][$menu][$area][$date] = [
                        'qty' => 0,
                        'nominal' => 0,
                    ];
                }
                $data[$waroeng][$menu][$area][$date]['qty'] = $qty;
                $data[$waroeng][$menu][$area][$date]['nominal'] = $nominal;
            }
            
            $output = ['data' => []];

        foreach ($data as $waroeng => $menus) {
            foreach ($menus as $menu => $dates) {
                foreach ($dates as $area => $areas) {
                $row = [
                    $area,
                    $waroeng,
                    $menu,
                ];
                foreach ($tanggal as $date) {
                    $date_str = $date->r_t_tanggal;
                    if (isset($areas[$date_str])) {
                        $row[] = $areas[$date_str]['qty'];
                        $row[] = $areas[$date_str]['nominal'];
                    } else {
                        $row[] = 0;
                        $row[] = 0;
                    }
                }
                $output['data'][] = $row;
            }
            }
        }

        return response()->json($output);
    }

    // function show(Request $request) {
    //     $dates = explode('to', $request->tanggal);
    //     $tanggal = DB::table('rekap_transaksi')
    //                 ->whereBetween('r_t_tanggal', $dates)
    //                 ->orderBy('r_t_tanggal', 'ASC')
    //                 ->get();

    //         if($request->area == '0'){
    //             $get = DB::table('rekap_transaksi_detail')
    //             ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
    //             ->join('m_w', 'm_w_id', 'r_t_m_w_id')
    //             ->whereBetween('r_t_tanggal', $dates);
    //         } else {
    //         $get = DB::table('rekap_transaksi_detail')
    //                 ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
    //                 ->join('m_w', 'm_w_id', 'r_t_m_w_id')
    //                 ->whereBetween('r_t_tanggal', $dates)
    //                 ->where('r_t_m_area_id', $request->area);
    //                 if ($request->waroeng != 'all') {
    //                     $get->where('r_t_m_w_id', $request->waroeng);
    //                 }
    //         }
         
    //     $get1 = $get->select('r_t_detail_m_produk_nama', 'm_w_nama')
    //                 ->groupBy('r_t_detail_m_produk_nama', 'm_w_nama')
    //                 ->get();
    //     $get2 = $get->selectRaw('sum(r_t_detail_qty) as qty, sum(r_t_detail_reguler_price) as nominal, r_t_tanggal, r_t_detail_m_produk_nama, m_w_nama')
    //                 ->groupBy('r_t_tanggal', 'r_t_detail_m_produk_nama', 'm_w_nama')
    //                 ->get();
    //     $data = [];
    //     foreach ($get2 as $key => $val_menu) {
    //         $waroeng = $val_menu->m_w_nama;
    //         $menu = $val_menu->r_t_detail_m_produk_nama;
    //         $date = $val_menu->r_t_tanggal;
    //         $qty = $val_menu->qty;
    //         $nominal = rupiah($val_menu->nominal * $qty, 0);
    //         if (!isset($data[$waroeng])) {
    //             $data[$waroeng] = [];
    //         }
    //         if (!isset($data[$waroeng][$menu])) {
    //             $data[$waroeng][$menu] = [];
    //         }
    //         if (!isset($data[$waroeng][$menu][$date])) {
    //             $data[$waroeng][$menu][$date] = [
    //                 'qty' => 0,
    //                 'nominal' => 0,
    //             ];
    //         }
    //         $data[$waroeng][$menu][$date]['qty'] = $qty;
    //         $data[$waroeng][$menu][$date]['nominal'] = $nominal;
    //     }
    //     $output = ['data' => []];

    //     foreach ($data as $waroeng => $menus) {
    //         foreach ($menus as $menu => $dates) {
    //             $row = [
    //                 $waroeng,
    //                 $menu,
    //             ];
    //             foreach ($tanggal as $date) {
    //                 $date_str = $date->r_t_tanggal;
    //                 if (isset($dates[$date_str])) {
    //                     $row[] = $dates[$date_str]['qty'];
    //                     $row[] = $dates[$date_str]['nominal'];
    //                 } else {
    //                     $row[] = 0;
    //                     $row[] = 0;
    //                 }
    //             }
    //             $output['data'][] = $row;
    //         }
    //     }

    //     return response()->json($output);
    // }
    
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

}
