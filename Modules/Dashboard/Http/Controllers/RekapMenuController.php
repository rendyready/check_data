<?php

namespace Modules\Dashboard\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RekapMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
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
        if (strpos($request->tanggal, 'to') !== false) {
        $dates = explode('to', $request->tanggal);
        $tanggal = DB::table('rekap_transaksi')
                ->select('r_t_tanggal')
                ->whereBetween('r_t_tanggal', $dates)
                ->orderBy('r_t_tanggal', 'asc')
                ->groupby('r_t_tanggal')
                ->get();
        } else {
            $tanggal = DB::table('rekap_transaksi')
                ->select('r_t_tanggal')
                ->where('r_t_tanggal', $request->tanggal)
                ->orderBy('r_t_tanggal', 'asc')
                ->groupby('r_t_tanggal')
                ->get();
        }
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

    public function select_trans(Request $request)
    {
        $trans = DB::table('m_transaksi_tipe')
            ->join('rekap_transaksi', 'r_t_m_t_t_id', 'm_t_t_id')
            ->select('m_t_t_id', 'm_t_t_name')
            ->where('r_t_m_w_id', $request->id_waroeng)
            ->orderBy('m_t_t_id', 'asc')
            ->get();

        $data = array();
        foreach ($trans as $val) {
            $data[$val->m_t_t_name] = [$val->m_t_t_name];
            $data['all'] = ['all transaksi'];
        }
        return response()->json($data);

    }

    function show(Request $request) {
            $tanggal1 = DB::table('rekap_transaksi')
                ->select('r_t_tanggal')
                ->orderBy('r_t_tanggal', 'asc')
                ->groupby('r_t_tanggal');
                if (strpos($request->tanggal, 'to') !== false) {
                    [$start, $end] = explode('to', $request->tanggal);
                    $tanggal1->whereBetween('r_t_tanggal', [$start, $end]);
                } else {
                    $tanggal1->where('r_t_tanggal', $request->tanggal);
                }
                $tanggal = $tanggal1->get();

            $get = DB::table('rekap_transaksi_detail')
                    ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
                    ->join('m_w', 'm_w_id', 'r_t_m_w_id')
                    ->join('m_produk', 'm_produk_id', 'r_t_detail_m_produk_id')
                    ->join('m_jenis_produk','m_jenis_produk_id', 'm_produk_m_jenis_produk_id')
                    ->join('m_transaksi_tipe', 'm_t_t_id', 'r_t_m_t_t_id')
                    ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id');
                    if (strpos($request->tanggal, 'to') !== false) {
                    [$start, $end] = explode('to', $request->tanggal);
                    $get->whereBetween('r_t_tanggal', [$start, $end]);
                    } else {
                    $get->where('r_t_tanggal', $request->tanggal);
                    }
                    if($request->area != 'all'){
                        $get->where('r_t_m_area_id', $request->area);
                        if ($request->waroeng != 'all') {
                            $get->where('r_t_m_w_id', $request->waroeng);
                            // if ($request->sesi != 'all') {
                            //     $get->where('rekap_modal_sesi', $request->sesi);
                                if ($request->trans != 'all') {
                                    $get->where('m_t_t_name', $request->trans);
                                }
                            // }
                        }
                    }
                
        $get2 = $get->selectRaw('sum(r_t_detail_qty) as qty, r_t_detail_reguler_price, r_t_tanggal, r_t_detail_m_produk_nama, m_w_nama, m_jenis_produk_id, m_jenis_produk_nama, m_t_t_name')
                    ->groupBy('r_t_tanggal', 'r_t_detail_m_produk_nama', 'm_w_nama', 'r_t_detail_reguler_price', 'm_jenis_produk_nama', 'm_jenis_produk_id', 'm_t_t_name')
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
            $transaksi = $val_menu->m_t_t_name;
            if (!isset($data[$waroeng])) {
                $data[$waroeng] = [];
            }
            if (!isset($data[$waroeng][$transaksi])) {
                $data[$waroeng][$transaksi] = [];
            }
            if (!isset($data[$waroeng][$transaksi][$kategori])) {
                $data[$waroeng][$transaksi][$kategori] = [];
            }
            if (!isset($data[$waroeng][$transaksi][$kategori][$menu])) {
                $data[$waroeng][$transaksi][$kategori][$menu] = [];
            }
            if (!isset($data[$waroeng][$transaksi][$kategori][$menu][$date])) {
                $data[$waroeng][$transaksi][$kategori][$menu][$date] = [
                    'qty' => 0,
                    'nominal' => 0,
                ];
            }
            $data[$waroeng][$transaksi][$kategori][$menu][$date]['qty'] += $qty;
            $data[$waroeng][$transaksi][$kategori][$menu][$date]['nominal'] = $nominal;
        }
        $output = ['data' => []];

        foreach ($data as $waroeng => $kategoris) {
            foreach ($kategoris as $transaksi => $transaksis) {
                foreach ($transaksis as $kategori => $menus) {
                    foreach ($menus as $menu => $dates) {
                    $row = [
                        $waroeng,
                        $transaksi,
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
        }

        return response()->json($output);
    }

}
