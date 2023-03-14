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
        }
        return response()->json($data);
    }

    public function select_bb(Request $request)
    {

        $bb = DB::table('m_stok')
            ->where('m_stok_gudang_code', $request->gudang)
            ->orderBy('m_stok_id', 'asc')
            ->get();
        $data = array();
        foreach ($bb as $val) {
            $data[$val->m_stok_m_produk_code] = [$val->m_stok_produk_nama];
        }
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
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
        return view('inventori::lap_rekap_stock', compact('data'));
    }

    public function show(Request $request)
    {
        [$start, $end] = explode('to', $request->tanggal);

        $stok_awal = DB::table('m_stok_detail')
            ->join('m_gudang', 'm_gudang_code', 'm_stok_detail_gudang_code')
            ->join('m_w', 'm_w_id', 'm_gudang_m_w_id')
            ->join('m_area', 'm_area_id', 'm_w_m_area_id')
            ->select(DB::raw('(SUM(m_stok_detail_masuk) - SUM(m_stok_detail_keluar)) as stok_awal'),DB::raw('SUM(m_stok_detail_masuk) as masuk'), DB::raw('SUM(m_stok_detail_keluar) as keluar'), DB::raw('SUM(m_stok_detail_so) as so'), DB::raw('AVG(m_stok_detail_hpp) as hpp'), 'm_area_nama', 'm_w_nama', 'm_stok_detail_m_produk_nama', 'm_stok_detail_satuan', 'm_stok_detail_catatan')
            ->where('m_stok_detail_m_produk_code', $request->bb)
            ->where('m_stok_detail_gudang_code', $request->gudang)
            ->where('m_stok_detail_tgl', '<', $start)
            ->groupby('m_area_nama', 'm_w_nama', 'm_stok_detail_m_produk_nama', 'm_stok_detail_satuan', 'm_stok_detail_catatan')
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
            ->get();

        $i = 0;
        $data = array();
        $stokawal = $stok_awal->stok_awal;
        $row = array();
        $row[] = date('d-M', strtotime($start)).' (to) '.date('d-M', strtotime($end));
        $row[] = $stok_awal->m_area_nama;
        $row[] = $stok_awal->m_w_nama;
        $row[] = $stok_awal->m_stok_detail_m_produk_nama;
        $row[] = '';
        $row[] = '';
        $row[] = '';
        $row[] = number_format($stokawal ?? 0);
        $row[] = $stok_awal->m_stok_detail_satuan;
        $row[] = rupiah($stok_awal->hpp, 0);
        $row[] = "Stok Akhir";
        $data[] = $row;
        foreach ($stok as $value) {
            $stokawal = $stok_awal->stok_awal;
            $row = array();
            $row[] = date('d-m-Y', strtotime($value->m_stok_detail_tgl));
            $row[] = $value->m_area_nama;
            $row[] = $value->m_w_nama;
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
            }
            $row[] = $value->m_stok_detail_satuan;
            $row[] = rupiah($value->m_stok_detail_hpp, 0);
            $row[] = $value->m_stok_detail_catatan;
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }

    // public function show(Request $request)
    // {
    //     // mendapatkan range tanggal dari input request
    //     [$startDate, $endDate] = explode('to' ,$request->tanggal);
        
    //     // mengambil data stok berdasarkan input request
    //     $stok = DB::table('m_stok')
    //                 ->join('m_gudang', 'm_gudang_code', 'm_stok_gudang_code')
    //                 ->join('m_w', 'm_w_id', 'm_gudang_m_w_id')
    //                 ->join('m_area', 'm_area_id', 'm_w_m_area_id')
    //                 ->where('m_gudang_m_w_id', $request->waroeng)
    //                 ->where('m_stok_gudang_code', $request->gudang)
    //                 ->where('m_stok_m_produk_code', $request->bb)
    //                 ->get();

    //     $start = Carbon::parse($startDate);
    //     $end = Carbon::parse($endDate);

    //     // array untuk menampung data
    //     $data = array();
        
    //     // loop untuk setiap tanggal dalam range tanggal
    //     for ($date = $start; $date->lte($end); $date->addDay()) {
    //         // array untuk menyimpan data pada setiap tanggal
    //         $row = array();
            
    //         // tambahkan data pada array $row
    //         $row[] = $date->format('Y-m-d');
            
    //         foreach ($stok as $key => $value) {
    //             // tambahkan data pada array $row
    //             $row[] = $value->m_area_nama;
    //             $row[] = $value->m_w_nama;
    //             $row[] = $value->m_stok_produk_nama;
                
    //             // ambil data stok detail untuk tanggal yang sedang di-loop
    //             $detail = DB::table('m_stok_detail')
    //                         ->selectRaw('m_stok_detail_tgl,  m_stok_detail_m_produk_nama, m_stok_detail_masuk, m_stok_detail_keluar, m_stok_detail_saldo, m_stok_detail_so, m_stok_detail_satuan, sum(m_stok_detail_hpp) as m_stok_detail_hpp, m_stok_detail_catatan')
    //                         ->groupby('m_stok_detail_tgl', 'm_stok_detail_m_produk_nama', 'm_stok_detail_masuk', 'm_stok_detail_keluar', 'm_stok_detail_saldo', 'm_stok_detail_so', 'm_stok_detail_satuan', 'm_stok_detail_catatan')
    //                         ->where('m_stok_detail_m_produk_code', $value->m_stok_m_produk_code)
    //                         ->where('m_stok_detail_tgl', $date->format('Y-m-d'))
    //                         ->first();
                
    //             // cek apakah data stok detail ditemukan
    //             if ($detail) {
    //                 // jika ditemukan, tambahkan data pada array $row
    //                 $row[] = $detail->m_stok_detail_masuk;
    //                 $row[] = $detail->m_stok_detail_keluar;
    //                 $row[] = $detail->m_stok_detail_saldo;
    //                 $row[] = $detail->m_stok_detail_so;
    //                 $row[] = $detail->m_stok_detail_satuan;
    //                 $row[] = rupiah($detail->m_stok_detail_hpp, 0);
    //                 $row[] = $detail->m_stok_detail_catatan;
    //             } else {
    //                 // jika tidak ditemukan, tambahkan nilai 0 pada array $row
    //                 $row[] = 0;
    //                 $row[] = 0;
    //                 $row[] = 0;
    //                 $row[] = 0;
    //                 $row[] = '-';
    //                 $row[] = '-';
    //                 $row[] = '-';
    //             }
    //         }
            
    //         // tambahkan array $row pada array $data
    //         $data[] = $row;
    //     }

    //     // kembalikan data dalam format JSON
    //     $output = array("data" => $data);
    //     return response()->json($output);
    // }

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
