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
        [$startDate, $endDate] = explode('to' ,$request->tanggal);
        $detail = DB::table('m_stok_detail')
                ->orderby('m_stok_detail_m_produk_code', 'ASC')
                ->whereBetween('m_stok_detail_tgl', [$startDate, $endDate])
                ->get();
        $get = DB::table('m_stok')
                ->join('m_gudang', 'm_gudang_code', 'm_stok_gudang_code')
                ->join('m_w', 'm_w_id', 'm_gudang_m_w_id')
                ->join('m_area', 'm_area_id', 'm_w_m_area_id')
                ->where('m_gudang_m_w_id', $request->waroeng)
                ->where('m_stok_gudang_code', $request->gudang)
                ->where('m_stok_m_produk_code', $request->bb)
                ->get();

        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

            $data = array();
            foreach ($get as $key => $value) {
                $row = array();
                foreach ($detail as $key => $valStok){
                for ($date = $start; $date->lte($end); $date->addDay()) {
                    $row[] = $date->format('Y-m-d') == date('d-m-Y', strtotime($valStok->m_stok_detail_tgl)) ? $date->format('Y-m-d') : 0;
                }
                $row[] = $value->m_area_nama;
                $row[] = $value->m_w_nama;
                $row[] = $value->m_stok_produk_nama;
                
                if($valStok->m_stok_detail_m_produk_code == $value->m_stok_m_produk_code){
                        $row[] = $valStok->m_stok_detail_masuk;
                        $row[] = $valStok->m_stok_detail_keluar;
                        $row[] = $valStok->m_stok_detail_saldo;
                        $row[] = $valStok->m_stok_detail_so;
                        $row[] = $valStok->m_stok_detail_satuan;
                        $row[] = rupiah($valStok->m_stok_detail_hpp, 0);
                        $row[] = $valStok->m_stok_detail_catatan;
                } else {
                        $row[] = 0;
                        $row[] = 0;
                        $row[] = 0;
                        $row[] = 0;
                        $row[] = 0;
                        $row[] = 0;
                        $row[] = 0;
                    }
                }
                $data[] = $row;
            }

        $output = array("data" => $data);
        return response()->json($output);
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
