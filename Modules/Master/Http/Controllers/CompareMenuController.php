<?php

namespace Modules\Master\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class CompareMenuController extends Controller
{
    public function index()
    {
        $data = new \stdClass();
        $data->area = DB::table('m_area')->orderBy('m_area_id', 'asc')->get();
        $data->menu = DB::table('m_jenis_produk')->orderBy('m_jenis_produk_id', 'asc')->get();
        $data->trans = DB::table('m_transaksi_tipe')->orderBy('m_t_t_id', 'asc')->get();
        return view('master::compare_menu', compact('data'));
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

    public function show(Request $request)
    {
        $menu = DB::table('m_w')
            ->leftjoin('m_jenis_nota', 'm_jenis_nota_m_w_id', 'm_w_id')
            ->leftjoin('m_menu_harga', 'm_menu_harga_m_jenis_nota_id', 'm_jenis_nota_id')
            ->leftjoin('m_area', 'm_area_id', 'm_w_m_area_id')
            ->leftjoin('m_transaksi_tipe', 'm_t_t_id', 'm_jenis_nota_m_t_t_id')
            ->leftJoin('m_produk', 'm_produk_id', 'm_menu_harga_m_produk_id')
            ->leftjoin('m_jenis_produk', 'm_jenis_produk_id', 'm_produk_m_jenis_produk_id')
            ->select('m_w_m_area_id', 'm_w_id', 'm_t_t_id', 'm_area_nama', 'm_w_nama', 'm_t_t_name', 'm_w_m_area_id', 'm_jenis_produk_nama', 'm_jenis_produk_id', DB::raw('count(m_menu_harga_id) count_pusat'));
        if ($request->area != 'all') {
            $menu->where('m_w_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $menu->where('m_jenis_nota_m_w_id', $request->waroeng);
            }
        }
        $menu->where('m_jenis_produk_id', $request->menu);
        if ($request->trans != 'all') {
            $menu->where('m_jenis_nota_m_t_t_id', $request->trans);
        }
        $menu = $menu->orderBy('m_w_m_area_id', 'ASC')
            ->orderBy('m_w_id', 'ASC')
            ->orderBy('m_jenis_produk_id', 'ASC')
            ->orderBy('m_t_t_id', 'ASC')
            ->groupby('m_w_m_area_id', 'm_w_id', 'm_t_t_id', 'm_area_nama', 'm_w_nama', 'm_t_t_name', 'm_w_m_area_id', 'm_jenis_produk_nama', 'm_jenis_produk_id')
            ->get();

        #GET Destination
        // $dest = DB::table('db_con')->whereIn('db_con_location', ['waroeng', 'area'])
        //     ->where('db_con_host', '!=', 'null')
        //     ->where('db_con_sync_status', 'aktif')
        // // ->whereNotIn('db_con_m_w_id', $getlist_dest)
        //     ->orderBy('db_con_id', 'ASC')
        //     ->get();

        // foreach ($dest as $key => $valDest) {
        //     $connName = "dest{$valDest->db_con_m_w_id}";
        //     Config::set("database.connections.{$connName}", [
        //         'driver' => $valDest->db_con_driver,
        //         'host' => $valDest->db_con_host,
        //         'port' => $valDest->db_con_port,
        //         'database' => $valDest->db_con_dbname,
        //         'username' => $valDest->db_con_username,
        //         'password' => Helper::customDecrypt($valDest->db_con_password),
        //         'charset' => 'utf8',
        //         'prefix' => '',
        //         'prefix_indexes' => true,
        //         'search_path' => 'public',
        //         'sslmode' => 'prefer',
        //     ]);

        // $menuWaroeng =

        $data = array();
        foreach ($menu as $value) {
            $row = array();
            $row[] = $value->m_area_nama;
            $row[] = $value->m_w_nama;
            $row[] = $value->m_jenis_produk_nama;
            $row[] = $value->m_t_t_name;
            // $row[] = $value->qtywaroeng;
            $waroeng = 1;
            $pusat = $value->count_pusat;
            $row[] = 1;
            $row[] = $pusat;
            $selisih = $waroeng - $pusat;
            $row[] = $selisih;
            $data[] = $row;
        }
        // }
        $output = array("data" => $data);
        return response()->json($output);
    }
}
