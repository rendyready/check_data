<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusMenuController extends Controller
{
    public function index()
    {
        $data = new \stdClass();
        $data->area = DB::table('m_area')->orderBy('m_area_id', 'asc')->get();
        $data->menu = DB::table('m_jenis_produk')->orderBy('m_jenis_produk_id', 'asc')->get();
        $data->trans = DB::table('m_transaksi_tipe')->orderBy('m_t_t_id', 'asc')->get();
        return view('master::status_menu', compact('data'));
    }

    public function select_waroeng(Request $request)
    {
        $waroeng = DB::table('m_w')
            ->select('m_w_id', 'm_w_nama', 'm_w_code')
            ->where('m_w_m_area_id', $request->area)
            ->orderBy('m_w_id', 'asc')
            ->get();
        $data = array();
        foreach ($waroeng as $val) {
            $data[$val->m_w_id] = [$val->m_w_nama];
            $data['all'] = ['all waroeng'];
        }
        return response()->json($data);
    }

    // public function showxxx(Request $request)
    // {
    //     $menu = DB::table('m_w')
    //         ->leftjoin('m_jenis_nota', 'm_jenis_nota_m_w_id', 'm_w_id')
    //         ->leftjoin('m_menu_harga', 'm_menu_harga_m_jenis_nota_id', 'm_jenis_nota_id')
    //         ->leftjoin('m_area', 'm_area_id', 'm_w_m_area_id')
    //         ->leftjoin('m_transaksi_tipe', 'm_t_t_id', 'm_jenis_nota_m_t_t_id')
    //         ->leftjoin('m_produk', 'm_produk_id', 'm_menu_harga_m_produk_id')
    //         ->leftjoin('m_jenis_produk', 'm_jenis_produk_id', 'm_produk_m_jenis_produk_id')
    //         ->select('m_area_nama', 'm_w_nama', 'm_produk_nama', 'm_menu_harga_nominal', 'm_t_t_name', 'm_w_m_kode_nota', 'm_menu_harga_status', 'm_menu_harga_tax_status', 'm_menu_harga_sc_status', 'm_w_m_area_id', 'm_w_id', 'm_produk_id', 'm_t_t_id', 'm_w_m_kode_nota', 'm_jenis_nota_m_t_t_id', 'm_jenis_produk_id', 'm_jenis_nota_m_w_id', 'm_menu_harga_m_jenis_nota_id', 'm_jenis_nota_id', 'm_produk_m_jenis_produk_id');
    //     if ($request->area != 'all') {
    //         $menu->where('m_w_m_area_id', $request->area);
    //         if ($request->waroeng != 'all') {
    //             $menu->where('m_w_id', $request->waroeng);
    //         }
    //     }
    //     $menu = $menu->orderBy('m_w_m_area_id', 'ASC')
    //         ->orderBy('m_w_id', 'ASC')
    //         ->orderBy('m_produk_id', 'ASC')
    //         ->orderBy('m_t_t_id', 'ASC')
    //         ->orderBy('m_w_m_kode_nota', 'ASC')
    //         ->get();

    //     $status = 'Tidak Aktif';
    //     $pajak = 'Tidak Aktif';
    //     $sc = 'Tidak Aktif';
    //     $produk = '';
    //     $harga = 0;
    //     $tipe = '';
    //     $nota = '';
    //     $stts = '';
    //     $tax = '';
    //     $service = '';
    //     $data = array();
    //     foreach ($menu as $value) {

    //         $row = array();
    //         $row[] = $value->m_area_nama;
    //         $row[] = $value->m_w_nama;
    //         if ($value->m_jenis_produk_id == $request->menu && $value->m_t_t_id == $request->trans) {
    //             $produk = $value->m_produk_nama;
    //             $harga = number_format($value->m_menu_harga_nominal);
    //             $tipe = $value->m_t_t_name;
    //             $nota = $value->m_w_m_kode_nota;
    //             $status = $value->m_menu_harga_status;
    //             $tax = $value->m_menu_harga_tax_status;
    //             $service = $value->m_menu_harga_sc_status;
    //         }
    //         $row[] = $produk;
    //         $row[] = $harga;
    //         $row[] = $tipe;
    //         $row[] = $nota;
    //         if ($stts != 0) {
    //             $status = 'Aktif';
    //             if ($stts == null) {
    //                 $status = '';
    //             }
    //         }
    //         $row[] = $status;
    //         if ($tax != 0) {
    //             $pajak = 'Aktif';
    //             if ($tax == null) {
    //                 $pajak = '';
    //             }
    //         }
    //         $row[] = $pajak;
    //         if ($service != 0) {
    //             $sc = 'Aktif';
    //             if ($service == null) {
    //                 $sc = '';
    //             }
    //         }
    //         $row[] = $sc;
    //         $data[] = $row;
    //     }
    //     $output = array("data" => $data);
    //     return response()->json($output);
    // }

    // public function show12121(Request $request)
    // {
    //     $menu1 = DB::table('m_w')
    //         ->leftjoin('m_jenis_nota', 'm_jenis_nota_m_w_id', 'm_w_id')
    //         ->leftjoin('m_menu_harga', 'm_menu_harga_m_jenis_nota_id', 'm_jenis_nota_id')
    //         ->leftjoin('m_area', 'm_area_id', 'm_w_m_area_id')
    //         ->leftjoin('m_transaksi_tipe', 'm_t_t_id', 'm_jenis_nota_m_t_t_id')
    //         ->leftjoin('m_produk', 'm_produk_id', 'm_menu_harga_m_produk_id')
    //         ->leftjoin('m_jenis_produk', 'm_jenis_produk_id', 'm_produk_m_jenis_produk_id')
    //         ->select('m_menu_harga_status');
    //     if ($request->area != 'all') {
    //         $menu1->where('m_w_m_area_id', $request->area);
    //         if ($request->waroeng != 'all') {
    //             $menu1->where('m_w_id', $request->waroeng);
    //         }
    //     }
    //     if ($request->menu != 'all') {
    //         $menu1->where('m_jenis_produk_id', $request->menu);
    //     }
    //     if ($request->trans != 'all') {
    //         $menu1->where('m_jenis_nota_m_t_t_id', $request->trans);
    //     }
    //     $menu1 = $menu1->first();

    //     $menu = DB::table('m_w')
    //         ->leftjoin('m_jenis_nota', 'm_jenis_nota_m_w_id', 'm_w_id')
    //         ->leftjoin('m_menu_harga', 'm_menu_harga_m_jenis_nota_id', 'm_jenis_nota_id')
    //         ->leftjoin('m_area', 'm_area_id', 'm_w_m_area_id')
    //         ->leftjoin('m_transaksi_tipe', 'm_t_t_id', 'm_jenis_nota_m_t_t_id')
    //         ->leftjoin('m_produk', 'm_produk_id', 'm_menu_harga_m_produk_id')
    //         ->leftjoin('m_jenis_produk', 'm_jenis_produk_id', 'm_produk_m_jenis_produk_id')
    //         ->select('m_area_nama', 'm_w_nama', 'm_produk_nama', 'm_menu_harga_nominal', 'm_t_t_name', 'm_w_m_kode_nota', 'm_menu_harga_status', 'm_menu_harga_tax_status', 'm_menu_harga_sc_status', 'm_w_m_area_id', 'm_w_id', 'm_produk_id', 'm_t_t_id', 'm_w_m_kode_nota');
    //     if ($request->area != 'all') {
    //         $menu->where('m_w_m_area_id', $request->area);
    //         if ($request->waroeng != 'all') {
    //             $menu->where('m_w_id', $request->waroeng);
    //         }
    //     }
    //     if ($request->menu != 'all') {
    //         if ($menu1 != null) {
    //             $menu->where('m_jenis_produk_id', $request->menu);
    //         }
    //     }
    //     if ($request->trans != 'all') {
    //         if ($menu1 != null) {
    //             $menu->where('m_jenis_nota_m_t_t_id', $request->trans);
    //         }
    //     }
    //     $menu = $menu->orderBy('m_w_m_area_id', 'ASC')
    //         ->orderBy('m_w_id', 'ASC')
    //         ->orderBy('m_produk_id', 'ASC')
    //         ->orderBy('m_t_t_id', 'ASC')
    //         ->orderBy('m_w_m_kode_nota', 'ASC')
    //         ->get();
    //     // return $menu;
    //     $status = 'Tidak Aktif';
    //     $pajak = 'Tidak Aktif';
    //     $sc = 'Tidak Aktif';
    //     $data = array();
    //     foreach ($menu as $value) {
    //         $row = array();
    //         $row[] = $value->m_area_nama;
    //         $row[] = $value->m_w_nama;
    //         $row[] = $value->m_produk_nama;
    //         $row[] = number_format($value->m_menu_harga_nominal);
    //         $row[] = $value->m_t_t_name;
    //         $row[] = $value->m_w_m_kode_nota;
    //         if ($value->m_menu_harga_status != 0) {
    //             $status = 'Aktif';
    //         }
    //         $row[] = $status;
    //         if ($value->m_menu_harga_tax_status != 0) {
    //             $pajak = 'Aktif';
    //         }
    //         $row[] = $pajak;
    //         if ($value->m_menu_harga_sc_status != 0) {
    //             $sc = 'Aktif';
    //         }
    //         $row[] = $sc;
    //         $data[] = $row;
    //     }
    //     $output = array("data" => $data);
    //     return response()->json($output);
    // }

    public function show(Request $request)
    {
        $menu = DB::table('m_w')
            ->leftjoin('m_jenis_nota', 'm_jenis_nota_m_w_id', 'm_w_id')
            ->leftjoin('m_menu_harga', 'm_menu_harga_m_jenis_nota_id', 'm_jenis_nota_id')
            ->leftjoin('m_area', 'm_area_id', 'm_w_m_area_id')
            ->leftjoin('m_transaksi_tipe', 'm_t_t_id', 'm_jenis_nota_m_t_t_id')
            ->leftjoin('m_produk', 'm_produk_id', 'm_menu_harga_m_produk_id')
            ->leftjoin('m_jenis_produk', 'm_jenis_produk_id', 'm_produk_m_jenis_produk_id')
            ->select('m_area_nama', 'm_w_nama', 'm_produk_nama', 'm_menu_harga_nominal', 'm_t_t_name', 'm_w_m_kode_nota', 'm_menu_harga_status', 'm_menu_harga_tax_status', 'm_menu_harga_sc_status', 'm_w_m_area_id', 'm_w_id', 'm_produk_id', 'm_t_t_id', 'm_w_m_kode_nota');
        if ($request->area != 'all') {
            $menu->where('m_w_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $menu->where('m_w_id', $request->waroeng);
            }
        }
        if ($request->menu != 'all') {
            $menu->where('m_jenis_produk_id', $request->menu);
        }
        if ($request->trans != 'all') {
            $menu->where('m_jenis_nota_m_t_t_id', $request->trans);
        }
        $menu = $menu->orderBy('m_w_m_area_id', 'ASC')
            ->orderBy('m_w_id', 'ASC')
            ->orderBy('m_produk_id', 'ASC')
            ->orderBy('m_t_t_id', 'ASC')
            ->orderBy('m_w_m_kode_nota', 'ASC')
            ->get();

        $status = 'Tidak Aktif';
        $pajak = 'Tidak Aktif';
        $sc = 'Tidak Aktif';
        $data = array();
        foreach ($menu as $value) {
            $row = array();
            $row[] = $value->m_area_nama;
            $row[] = $value->m_w_nama;
            $row[] = $value->m_produk_nama;
            $row[] = number_format($value->m_menu_harga_nominal);
            $row[] = $value->m_t_t_name;
            $row[] = $value->m_w_m_kode_nota;
            if ($value->m_menu_harga_status != 0) {
                $status = 'Aktif';
            }
            $row[] = $status;
            if ($value->m_menu_harga_tax_status != 0) {
                $pajak = 'Aktif';
            }
            $row[] = $pajak;
            if ($value->m_menu_harga_sc_status != 0) {
                $sc = 'Aktif';
            }
            $row[] = $sc;
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }

}