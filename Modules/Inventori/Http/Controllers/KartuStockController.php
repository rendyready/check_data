<?php

namespace Modules\Inventori\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;

class KartuStockController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('inventori::index');
    }

    public function kartu_stk()
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
        return view('inventori::lap_kartu_stock', compact('data'));
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
        }
        return response()->json($data);
    }

    public function select_gudang(Request $request)
    {

        $gudang = DB::table('m_gudang')
            ->where('m_gudang_m_w_id', $request->waroeng)
            ->orderBy('m_gudang_id', 'asc')
            ->get();
        $data = array();
        foreach ($gudang as $val) {
            $data[$val->m_gudang_code] = [$val->m_gudang_nama];
            $data['all'] = 'gudang utama & produksi waroeng';
        }
        return response()->json($data);
    }

    public function select_bb(Request $request)
    {

        $bb2 = DB::table('m_stok');
        if($request->gudang != 'all'){
            $bb2->where('m_stok_gudang_code', $request->gudang);
        } else {
            $bb2->where(function($query) {
                $query->where('m_stok_gudang_code', '60001')->where('m_stok_gudang_code', '60002');
            });
        }
        $bb = $bb2->orderBy('m_stok_id', 'asc')
            ->get();
        $data = array();
        foreach ($bb as $val) {
            $data[$val->m_stok_m_produk_code] = [$val->m_stok_produk_nama];
            $data['all'] = 'All Bahan Baku';
        }
        return response()->json($data);
    }

    public function show(Request $request)
    {
        [$start, $end] = explode('to', $request->tanggal);
        
        //stokawal2
        $master_stok = DB::table('m_stok')
            ->select('m_stok_awal')
            ->where('m_stok_gudang_code', $request->gudang)
            ->where('m_stok_m_produk_code', $request->bb)
            ->first();

        //stok awal1
        $stok_awal = DB::table('m_stok_detail')
            ->join('m_gudang', 'm_gudang_code', 'm_stok_detail_gudang_code')
            ->select(DB::raw('(SUM(m_stok_detail_masuk) - SUM(m_stok_detail_keluar) + SUM(m_stok_detail_so)) as stok_awal'))
            ->where('m_stok_detail_m_produk_code', $request->bb)
            ->where('m_stok_detail_gudang_code', $request->gudang)
            ->where('m_stok_detail_tgl', '<', $start)
            ->first();

        $stok = DB::table('m_stok_detail')
            ->join('m_gudang', 'm_gudang_code', 'm_stok_detail_gudang_code')
            ->join('m_w', 'm_w_id', 'm_gudang_m_w_id')
            ->join('m_area', 'm_area_id', 'm_w_m_area_id')
            ->whereBetween('m_stok_detail_tgl', [$start, $end])
            ->where('m_area_id', $request->area)
            ->where('m_gudang_m_w_id', $request->waroeng)
            ->where('m_stok_detail_gudang_code', $request->gudang)
            ->where('m_stok_detail_m_produk_code', $request->bb)
            ->orderby('m_stok_detail_created_at', 'ASC')
            ->get();

        $i = 0;
        $data = array();
        if($stok_awal->stok_awal == 0){
            $stokawal = $master_stok->m_stok_awal;
        } else {
            $stokawal = $stok_awal->stok_awal;
        }
        $row = array();
        $row[] = '';
        $row[] = '';
        $row[] = '';
        $row[] = '';
        $row[] = 'Stok Awal';
        $row[] = number_format($stokawal ?? 0);
        $row[] = '';
        $row[] = '';
        $row[] = '';
        $data[] = $row;
        foreach ($stok as $value) {
            // $stokawal = $stok_awal->stok_awal;
            $row = array();
            $row[] = date('d-m-Y', strtotime($value->m_stok_detail_tgl));
            $row[] = $value->m_stok_detail_m_produk_nama;
            $row[] = number_format($value->m_stok_detail_masuk ?? 0);
            $row[] = number_format($value->m_stok_detail_keluar ?? 0);
            $row[] = number_format($value->m_stok_detail_so ?? 0);
            if($i == 0){
                $stokkeluar = $stokawal + $value->m_stok_detail_masuk - $value->m_stok_detail_keluar + $value->m_stok_detail_so;
                $row[] = $stokkeluar;
                $i = 1;
            } else {
                $row[] = $stokkeluar + $value->m_stok_detail_masuk - $value->m_stok_detail_keluar + $value->m_stok_detail_so;
                $stokkeluar = $stokkeluar + $value->m_stok_detail_masuk - $value->m_stok_detail_keluar + $value->m_stok_detail_so;
            }
            $row[] = $value->m_stok_detail_satuan;
            $row[] = rupiah($value->m_stok_detail_hpp, 0);
            $row[] = $value->m_stok_detail_catatan;
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }

    public function rekap_stk()
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
        return view('inventori::lap_kartu_stock_rekap_stock', compact('data'));
    }

    public function tampil_rekap(Request $request)
    {
        [$start, $end] = explode('to', $request->tanggal);

        $master_stok2 = DB::table('m_stok')
                ->selectRaw('m_stok_produk_nama, SUM(m_stok_awal) as stok_awal, SUM(m_stok_masuk) as masuk, SUM(m_stok_keluar) as keluar, SUM(m_stok_saldo) as saldo, m_stok_hpp, m_stok_satuan');
                if($request->gudang != 'all'){
                    $master_stok2->where('m_stok_gudang_code', $request->gudang);
                } else {
                    $master_stok2->where('m_stok_gudang_code', 60001)
                    ->where('m_stok_gudang_code', 60002);
                }
                if($request->bb != 'all'){
                    $master_stok2->where('m_stok_m_produk_code', $request->bb);
                }
        $master_stok = $master_stok2->groupby('m_stok_produk_nama', 'm_stok_hpp', 'm_stok_satuan')->orderby('m_stok_produk_nama', 'ASC')->get();

        $data = array();
        foreach ($master_stok as $key => $value) {
            $row = array();
            $row[] = $value->m_stok_produk_nama;
            $row[] = number_format($value->stok_awal);
            $row[] = number_format($value->masuk ?? 0);
            $row[] = number_format($value->keluar ?? 0);
            $row[] = number_format($value->saldo ?? 0);
            $row[] = $value->m_stok_satuan;
            $row[] = rupiah($value->m_stok_hpp, 0);
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }
}


// public function tampil_rekap(Request $request)
//     {
//         [$start, $end] = explode('to', $request->tanggal);

//         $m_stok2 = DB::table('m_stok')
//                 ->select('m_stok_awal', 'm_stok_hpp')
//                 ->where('m_stok_gudang_code', $request->gudang);
//                 if($request->bb != 'all'){
//                     $m_stok2->where('m_stok_m_produk_code', $request->bb);
//                 }
//         $m_stok = $m_stok2->get();

//         $stok_awal = DB::table('m_stok_detail')
//             ->join('m_gudang', 'm_gudang_code', 'm_stok_detail_gudang_code')
//             ->join('m_stok', 'm_stok_m_produk_code', 'm_stok_detail_m_produk_code')
//             ->selectRaw('SUM(m_stok_detail_masuk) - SUM(m_stok_detail_keluar) + SUM(m_stok_detail_so) as stok_awal')
//             ->where('m_stok_detail_tgl', '<', $start)
//             ->where('m_stok_detail_gudang_code', $request->gudang)->get();
//         //     if($request->bb != 'all'){
//         //         $stok_awal2->where('m_stok_detail_m_produk_code', $request->bb);
//         //     }
//         // $stok_awal = $stok_awal2->get();

//         $stok2 = DB::table('m_stok_detail')
//             ->join('m_gudang', 'm_gudang_code', 'm_stok_detail_gudang_code')
//             ->join('m_w', 'm_w_id', 'm_gudang_m_w_id')
//             ->join('m_area', 'm_area_id', 'm_w_m_area_id')
//             ->selectRaw('m_stok_detail_m_produk_nama, SUM(m_stok_detail_masuk) as masuk, SUM(m_stok_detail_keluar) as keluar, SUM(m_stok_detail_so) as so, m_stok_detail_satuan, AVG(m_stok_detail_hpp) as hpp, COUNT(m_stok_detail_m_produk_code) as count_avg, SUM(m_stok_detail_hpp) as sum_hpp')
//             ->whereBetween('m_stok_detail_tgl', [$start, $end])
//             ->where('m_area_id', $request->area)
//             ->where('m_gudang_m_w_id', $request->waroeng)
//             ->where('m_stok_detail_gudang_code', $request->gudang);
//             if($request->bb != 'all'){
//                 $stok2->where('m_stok_detail_m_produk_code', $request->bb);
//             }
//             $stok = $stok2->groupby('m_stok_detail_m_produk_nama', 'm_stok_detail_satuan')->get();

//         $data = array();
//         foreach ($stok as $key => $value) {
//             foreach ($stok_awal as $key => $awal) {
//                 foreach ($m_stok as $key => $master) {
//                     $row = array();
//                     $row[] = $value->m_stok_detail_m_produk_nama;
//                     if($awal->stok_awal == '0'){
//                         $row[] = number_format($awal->stok_awal);
//                     } else {
//                         $row[] = number_format($master->m_stok_awal);
//                     }
//                     $row[] = number_format($value->masuk ?? 0);
//                     $row[] = number_format($value->keluar ?? 0);
//                     $row[] = number_format($value->so ?? 0);
//                     if($awal->stok_awal == '0'){
//                         $row[] = number_format($awal->stok_awal + $value->masuk - $value->keluar + $value->so);
//                     } else {
//                         $row[] = number_format($master->m_stok_awal + $value->masuk - $value->keluar + $value->so);
//                     }
//                     $row[] = $value->m_stok_detail_satuan;
//                     if($awal->stok_awal == '0'){
//                         $row[] = rupiah($value->hpp, 0);
//                     } else {
//                         $average = (($value->sum_hpp + $master->m_stok_hpp)/($value->count_avg + 1));
//                         $row[] = rupiah($average, 0);
//                     }
//                     $data[] = $row;
//                 }
//             }
//         }
//         $output = array("data" => $data);
//         return response()->json($output);
//     }