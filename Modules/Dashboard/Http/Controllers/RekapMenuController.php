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
        $dates = explode('to', $request->tanggal);
        $tanggal = DB::table('rekap_transaksi')
                ->select('r_t_tanggal')
                ->whereBetween('r_t_tanggal', $dates)
                ->orderBy('r_t_tanggal', 'asc')
                ->groupby('r_t_tanggal')
                ->get();
        $data = [];
        foreach ($tanggal as $val) {
            $data[] = $val->r_t_tanggal;
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

    public function select_sif(Request $request)
    {
        $dates = explode('to', $request->id_tanggal);

        $sesi = DB::table('rekap_modal')
            ->select('rekap_modal_sesi', 'rekap_modal_id')
            ->whereBetween('rekap_modal_tanggal', $dates)
            ->where('rekap_modal_m_area_id', $request->id_area)
            ->where('rekap_modal_m_w_id', $request->id_waroeng)
            ->orderBy('rekap_modal_id', 'asc')
            ->get();
        $data = array();
        foreach ($sesi as $val) {
            $data[$val->rekap_modal_id] = [$val->rekap_modal_sesi];
            $data['all'] = ['all sesi'];
        }
        return response()->json($data);
    }

    public function select_trans(Request $request)
    {
        $trans = DB::table('m_transaksi_tipe')
            ->join('rekap_transaksi', 'r_t_m_t_t_id', 'm_t_t_id')
            ->select('m_t_t_id', 'm_t_t_name', 'r_t_rekap_modal_id')
            ->where('r_t_rekap_modal_id', $request->id_sif)
            ->orderBy('m_t_t_id', 'asc')
            ->get();
        $data = array();
        foreach ($trans as $val) {
            $data[$val->m_t_t_id] = [$val->m_t_t_name];
            $data['all'] = ['all transaksi'];
        }
        return response()->json($data);
    }

    function show(Request $request) {
        $dates = explode('to', $request->tanggal);
        $tanggal = DB::table('rekap_transaksi')
                ->select('r_t_tanggal')
                ->whereBetween('r_t_tanggal', $dates)
                ->orderBy('r_t_tanggal', 'asc')
                ->groupby('r_t_tanggal')
                ->get();

            $get = DB::table('rekap_transaksi_detail')
                    ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
                    ->join('m_w', 'm_w_id', 'r_t_m_w_id')
                    ->join('m_produk', 'm_produk_id', 'r_t_detail_m_produk_id')
                    ->join('m_jenis_produk','m_jenis_produk_id', 'm_produk_m_jenis_produk_id')
                    // ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
                    ->whereBetween('r_t_tanggal', $dates);
                    if($request->area != 'all'){
                        $get->where('r_t_m_area_id', $request->area);
                        if ($request->waroeng != 'all') {
                            $get->where('r_t_m_w_id', $request->waroeng);
                            if ($request->sesi != 'all') {
                                $get->where('r_t_rekap_modal_id', $request->sesi);
                                if ($request->trans != 'all') {
                                    $get->where('r_t_m_t_t_id', $request->trans);
                                }
                            }
                        }
                    }
            
        $get2 = $get->selectRaw('sum(r_t_detail_qty) as qty, r_t_detail_reguler_price, r_t_tanggal, r_t_detail_m_produk_nama, m_w_nama, m_jenis_produk_id, m_jenis_produk_nama')
                    ->groupBy('r_t_tanggal', 'r_t_detail_m_produk_nama', 'm_w_nama', 'r_t_detail_reguler_price', 'm_jenis_produk_nama', 'm_jenis_produk_id')
                    ->orderby('m_jenis_produk_id', 'ASC')
                    ->orderby('r_t_detail_m_produk_nama', 'ASC')
                    ->get();
        $data = [];
        foreach ($get2 as $key => $val_menu) {
            $waroeng = $val_menu->m_w_nama;
            $menu = $val_menu->r_t_detail_m_produk_nama;
            $date = $val_menu->r_t_tanggal;
            $qty = $val_menu->qty;
            $nominal = number_format($val_menu->r_t_detail_reguler_price * $qty);
            $kategori = $val_menu->m_jenis_produk_nama;
            if (!isset($data[$waroeng])) {
                $data[$waroeng] = [];
            }
            if (!isset($data[$waroeng][$kategori])) {
                $data[$waroeng][$kategori] = [];
            }
            if (!isset($data[$waroeng][$kategori][$menu])) {
                $data[$waroeng][$kategori][$menu] = [];
            }
            if (!isset($data[$waroeng][$kategori][$menu][$date])) {
                $data[$waroeng][$kategori][$menu][$date] = [
                    'qty' => 0,
                    'nominal' => 0,
                ];
            }
            $data[$waroeng][$kategori][$menu][$date]['qty'] += $qty;
            $data[$waroeng][$kategori][$menu][$date]['nominal'] = $nominal;
        }
        $output = ['data' => []];

        foreach ($data as $waroeng => $kategoris) {
            foreach ($kategoris as $kategori => $menus) {
                foreach ($menus as $menu => $dates) {
                    $row = [
                        $waroeng,
                        $kategori,
                        $menu,
                    ];
                    foreach ($tanggal as $date) {
                        $date_str = $date->r_t_tanggal;
                        if (isset($dates[$date_str])) {
                            $row[] = $dates[$date_str]['qty'];
                            $row[] = $dates[$date_str]['nominal'];
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
