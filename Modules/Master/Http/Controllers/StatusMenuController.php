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
        if ($request->area != 'all') {
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
    }

    public function show(Request $request)
    {
        $databaseHost = env('DB_HOST');
        if ($databaseHost == '192.168.50.2') {
            try {
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
                config(['database.connections.db_connection2' => $koneksiPusat]);
            } catch (QueryException $e) {
                $client = 'Kesalahan koneksi';
                $dateTime = 'Kesalahan koneksi';
            }
            $menuPusat = DB::connection('db_connection2')->table('m_menu_harga')
                ->leftjoin('m_jenis_nota', 'm_jenis_nota_id', 'm_menu_harga_m_jenis_nota_id')
                ->leftjoin('m_w', 'm_w_id', 'm_jenis_nota_m_w_id')
                ->leftjoin('m_produk', 'm_produk_id', 'm_menu_harga_m_produk_id')
                ->leftjoin('m_jenis_produk', 'm_jenis_produk_id', 'm_produk_m_jenis_produk_id')
                ->select('m_w_id', 'm_menu_harga_id', 'm_menu_harga_updated_at', 'm_menu_harga_client_target');
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
            $menuPusat = $menuPusat->get();

            $menu = DB::table('m_w')
                ->leftjoin('m_jenis_nota', 'm_jenis_nota_m_w_id', 'm_w_id')
                ->leftjoin('m_menu_harga', 'm_menu_harga_m_jenis_nota_id', 'm_jenis_nota_id')
                ->leftjoin('m_area', 'm_area_id', 'm_w_m_area_id')
                ->leftjoin('m_transaksi_tipe', 'm_t_t_id', 'm_jenis_nota_m_t_t_id')
                ->leftjoin('m_produk', 'm_produk_id', 'm_menu_harga_m_produk_id')
                ->leftjoin('m_jenis_produk', 'm_jenis_produk_id', 'm_produk_m_jenis_produk_id')
                ->select('m_area_nama', 'm_w_nama', 'm_produk_nama', 'm_menu_harga_nominal', 'm_t_t_name', 'm_w_m_kode_nota', 'm_menu_harga_status', 'm_menu_harga_tax_status', 'm_produk_tax', 'm_w_m_pajak_id', 'm_menu_harga_sc_status', 'm_produk_sc', 'm_w_m_sc_id', 'm_w_m_area_id', 'm_w_id', 'm_produk_id', 'm_t_t_id', 'm_w_m_kode_nota', 'm_menu_harga_id', 'm_menu_harga_client_target', 'm_menu_harga_updated_at');
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
        } else {
            $menu = DB::table('m_w')
                ->leftjoin('m_jenis_nota', 'm_jenis_nota_m_w_id', 'm_w_id')
                ->leftjoin('m_menu_harga', 'm_menu_harga_m_jenis_nota_id', 'm_jenis_nota_id')
                ->leftjoin('m_area', 'm_area_id', 'm_w_m_area_id')
                ->leftjoin('m_transaksi_tipe', 'm_t_t_id', 'm_jenis_nota_m_t_t_id')
                ->leftjoin('m_produk', 'm_produk_id', 'm_menu_harga_m_produk_id')
                ->leftjoin('m_jenis_produk', 'm_jenis_produk_id', 'm_produk_m_jenis_produk_id')
                ->select('m_area_nama', 'm_w_nama', 'm_produk_nama', 'm_menu_harga_nominal', 'm_t_t_name', 'm_w_m_kode_nota', 'm_menu_harga_status', 'm_menu_harga_tax_status', 'm_produk_tax', 'm_w_m_pajak_id', 'm_menu_harga_sc_status', 'm_produk_sc', 'm_w_m_sc_id', 'm_w_m_area_id', 'm_w_id', 'm_produk_id', 'm_t_t_id', 'm_w_m_kode_nota', 'm_menu_harga_id', 'm_menu_harga_client_target', 'm_menu_harga_updated_at');
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
        }

        $data = array();
        foreach ($menu as $value) {
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
            if ($value->m_menu_harga_tax_status != 0 && $value->m_produk_tax != 0) {
                $pajak = 'Aktif';
            }
            $row[] = $pajak;
            if ($value->m_menu_harga_sc_status != 0 && $value->m_produk_sc != 0) {
                $sc = 'Aktif';
            }
            $row[] = $sc;
            if ($databaseHost == '192.168.50.2') {
                foreach ($menuPusat as $valPusat) {
                    if ($value->m_menu_harga_id == $valPusat->m_menu_harga_id) {
                        try {
                            $client = stripos($valPusat->m_menu_harga_client_target, ':' . $valPusat->m_w_id . ':') !== false ? 'belum terkirim' : 'terkirim';
                            $date = substr($valPusat->m_menu_harga_updated_at, 0, -3);
                            $dateTime = $date;
                        } catch (QueryException $e) {
                            $client = 'Kesalahan koneksi';
                            $dateTime = 'Kesalahan koneksi';
                        }
                    }
                }
            } else {
                $client = stripos($value->m_menu_harga_client_target, ':' . $value->m_w_id . ':') !== false ? 'belum terkirim' : 'terkirim';
                $date = substr($value->m_menu_harga_updated_at, 0, -3);
                $dateTime = $date;
            }
            $row[] = $client;
            $row[] = $dateTime;
            $data[] = $row;
        }

        $output = array(
            "data" => $data,
        );
        return response()->json($output);
    }

}
