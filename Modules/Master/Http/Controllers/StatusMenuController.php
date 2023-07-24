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

    public function showxx(Request $request)
    {
        $produk = DB::table('m_produk')
            ->select('m_produk_nama', 'm_produk_m_jenis_produk_id')
            ->orderby('m_produk_id', 'asc')->get();

        $menu = DB::table('m_w')
            ->leftjoin('m_jenis_nota', 'm_jenis_nota_m_w_id', 'm_w_id')
            ->leftjoin('m_menu_harga', 'm_menu_harga_m_jenis_nota_id', 'm_jenis_nota_id')
            ->leftjoin('m_area', 'm_area_id', 'm_w_m_area_id')
            ->leftjoin('m_transaksi_tipe', 'm_t_t_id', 'm_jenis_nota_m_t_t_id')
            ->leftjoin('m_produk', 'm_produk_id', 'm_menu_harga_m_produk_id')
            ->leftjoin('m_jenis_produk', 'm_jenis_produk_id', 'm_produk_m_jenis_produk_id')
            ->select(
                'm_area_nama',
                'm_w_nama',
                'm_produk_nama',
                'm_w_m_kode_nota',
                DB::raw("COALESCE(m_t_t_name, '0') AS m_t_t_name"),
                DB::raw("COALESCE(m_menu_harga_nominal, 0) AS m_menu_harga_nominal"),
                DB::raw("COALESCE(m_menu_harga_status, '0') AS m_menu_harga_status"),
                DB::raw("COALESCE(m_menu_harga_tax_status, '0') AS m_menu_harga_tax_status"),
                DB::raw("COALESCE(m_menu_harga_sc_status, '0') AS m_menu_harga_sc_status"),
                DB::raw("COALESCE(m_jenis_nota_m_t_t_id, 0) AS m_jenis_nota_m_t_t_id"),
                DB::raw("COALESCE(m_jenis_produk_id, 0) AS m_jenis_produk_id"),
                'm_w_m_area_id',
                'm_w_id',
                'm_w_m_kode_nota'
            );
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
            ->orderBy('m_w_m_kode_nota', 'ASC')
            ->get();

        $status = 'Tidak Aktif';
        $pajak = 'Tidak Aktif';
        $sc = 'Tidak Aktif';
        $i = 1;
        $data = array();
        foreach ($menu as $value) {
            $row = array();
            $row['area'] = $value->m_area_nama;
            $row['waroeng'] = $value->m_w_nama;

            ${$valListRekap . '-icecream'} = 0;
            ${$valListRekap . '-mineral'} = 0;
            ${$valListRekap . '-krupuk'} = 0;
            ${$valListRekap . '-wbdbb'} = 0;
            ${$valListRekap . '-wbdfrozen'} = 0;
            ${$valListRekap . '-pajakreguler'} = 0;
            ${$valListRekap . '-pajakojol'} = 0;

            $row['menu'][$value->m_produk_nama] = 0;
            $row['harga'][$value->m_produk_nama] = 0;
            $row['tipe'][$value->m_produk_nama] = 0;
            $row['nota'][$value->m_produk_nama] = 0;
            $row['status'][$value->m_produk_nama] = 0;
            $row['pajak'][$value->m_produk_nama] = 0;
            $row['service'][$value->m_produk_nama] = 0;
            foreach ($produk as $valProd) {
                if ($valProd->m_produk_nama == $value->m_produk_nama && $request->menu == $value->m_jenis_produk_id && $valProd->m_produk_m_jenis_produk_id == $value->m_jenis_produk_id && $request->trans == $value->m_jenis_nota_m_t_t_id) {
                    $row['menu'][$value->m_produk_nama] = $value->m_produk_nama;
                    $row['harga'][$value->m_produk_nama] = number_format($value->m_menu_harga_nominal);
                    $row['tipe'][$valProd->m_produk_nama] = $value->m_t_t_name;
                    $row['nota'][$valProd->m_produk_nama] = $value->m_w_m_kode_nota;
                    if ($value->m_menu_harga_status != 0) {
                        $status = 'Aktif';
                    }
                    $row['status'][$valProd->m_produk_nama] = $status;
                    if ($value->m_menu_harga_tax_status != 0) {
                        $pajak = 'Aktif';
                    }
                    $row['pajak'][$valProd->m_produk_nama] = $pajak;
                    if ($value->m_menu_harga_sc_status != 0) {
                        $sc = 'Aktif';
                    }
                    $row['service'][$valProd->m_produk_nama] = $sc;

                }
            }
            // return $value->m_produk_nama;
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }

    public function show(Request $request)
    {
        $clientIP = $request->ip();
        // return $clientIP;
        if ($clientIP === '192.168.50.2') {
            $koneksiPusat = [
                'driver' => 'pgsql',
                'host' => '10.20.30.21',
                'port' => '5884',
                'database' => 'admin_sipedas_v4',
                'username' => 'admin_spesialw55',
                'password' => 'yoyokHW55',
                'charset' => 'utf8',
                'prefix' => '',
                'prefix_indexes' => true,
                'search_path' => 'public',
                'sslmode' => 'prefer',
            ];
        } else {
            $koneksiPusat = [
                'driver' => 'pgsql',
                'host' => '192.168.88.4',
                'port' => '5432',
                'database' => 'admin_sipedas_v4',
                'username' => 'admin_spesialw55',
                'password' => 'yoyokHW55',
                'charset' => 'utf8',
                'prefix' => '',
                'prefix_indexes' => true,
                'search_path' => 'public',
                'sslmode' => 'prefer',
            ];
        }
        config(['database.connections.db_connection2' => $koneksiPusat]);

        $menu = DB::table('m_w')
            ->leftjoin('m_jenis_nota', 'm_jenis_nota_m_w_id', 'm_w_id')
            ->leftjoin('m_menu_harga', 'm_menu_harga_m_jenis_nota_id', 'm_jenis_nota_id')
            ->leftjoin('m_area', 'm_area_id', 'm_w_m_area_id')
            ->leftjoin('m_transaksi_tipe', 'm_t_t_id', 'm_jenis_nota_m_t_t_id')
            ->leftjoin('m_produk', 'm_produk_id', 'm_menu_harga_m_produk_id')
            ->leftjoin('m_jenis_produk', 'm_jenis_produk_id', 'm_produk_m_jenis_produk_id')
            ->select('m_area_nama', 'm_w_nama', 'm_produk_nama', 'm_menu_harga_nominal', 'm_t_t_name', 'm_w_m_kode_nota', 'm_menu_harga_status', 'm_menu_harga_tax_status', 'm_produk_tax', 'm_w_m_pajak_id', 'm_menu_harga_sc_status', 'm_produk_sc', 'm_w_m_sc_id', 'm_w_m_area_id', 'm_w_id', 'm_produk_id', 'm_t_t_id', 'm_w_m_kode_nota', 'm_menu_harga_id', 'm_menu_harga_client_target');
        if ($request->area != 'all') {
            $menu->where('m_w_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $menu->where('m_jenis_nota_m_w_id', $request->waroeng);
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

        $data = array();
        foreach ($menu as $value) {
            $menuPusat = DB::connection('db_connection2')->table('m_w')
                ->leftjoin('m_jenis_nota', 'm_jenis_nota_m_w_id', 'm_w_id')
                ->leftjoin('m_menu_harga', 'm_menu_harga_m_jenis_nota_id', 'm_jenis_nota_id')
                ->leftjoin('m_area', 'm_area_id', 'm_w_m_area_id')
                ->leftjoin('m_transaksi_tipe', 'm_t_t_id', 'm_jenis_nota_m_t_t_id')
                ->leftjoin('m_produk', 'm_produk_id', 'm_menu_harga_m_produk_id')
                ->leftjoin('m_jenis_produk', 'm_jenis_produk_id', 'm_produk_m_jenis_produk_id')
                ->select('m_area_nama', 'm_w_nama', 'm_produk_nama', 'm_menu_harga_nominal', 'm_t_t_name', 'm_w_m_kode_nota', 'm_menu_harga_status', 'm_menu_harga_tax_status', 'm_produk_tax', 'm_w_m_pajak_id', 'm_menu_harga_sc_status', 'm_produk_sc', 'm_w_m_sc_id', 'm_w_m_area_id', 'm_w_id', 'm_produk_id', 'm_t_t_id', 'm_w_m_kode_nota', 'm_menu_harga_id', 'm_menu_harga_client_target');
            if ($request->area != 'all') {
                $menuPusat->where('m_w_m_area_id', $request->area);
                if ($request->waroeng != 'all') {
                    $menuPusat->where('m_jenis_nota_m_w_id', $request->waroeng);
                }
            }
            if ($request->menu != 'all') {
                $menuPusat->where('m_jenis_produk_id', $request->menu);
            }
            if ($request->trans != 'all') {
                $menuPusat->where('m_jenis_nota_m_t_t_id', $request->trans);
            }
            $menuPusat = $menuPusat->orderBy('m_w_m_area_id', 'ASC')
                ->orderBy('m_w_id', 'ASC')
                ->orderBy('m_produk_id', 'ASC')
                ->orderBy('m_t_t_id', 'ASC')
                ->orderBy('m_w_m_kode_nota', 'ASC')
                ->first();

            $status = 'Tidak Aktif';
            $pajak = 'Tidak Aktif';
            $sc = 'Tidak Aktif';

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
            if ($value->m_menu_harga_tax_status != 0 && $value->m_produk_tax != 0 && $value->m_w_m_pajak_id != 1) {
                $pajak = 'Aktif';
            }
            $row[] = $pajak;
            if ($value->m_menu_harga_sc_status != 0 && $value->m_produk_sc != 0 && $value->m_w_m_sc_id != 1) {
                $sc = 'Aktif';
            }
            $row[] = $sc;
            try {
                $client = stripos($menuPusat->m_menu_harga_client_target, ':' . $menuPusat->m_w_id . ':') !== false ? 'belum terkirim' : 'terkirim';
            } catch (QueryException $e) {
                $client = 'Kesalahan koneksi';
            }
            $row[] = $client;

            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }

}
