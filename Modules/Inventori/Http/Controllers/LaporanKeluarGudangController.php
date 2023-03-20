<?php

namespace Modules\Inventori\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;

class LaporanKeluarGudangController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('inventori::index');
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

    public function select_user(Request $request)
    {
        $user = DB::table('users')
            ->select('users_id', 'name')
            ->where('waroeng_id', $request->id_waroeng)
            ->orderBy('users_id', 'asc')
            ->get();
        $data = array();
        foreach ($user as $val) {
            $data[$val->users_id] = [$val->name];
            $data['all'] = 'All Operator';
        }
        return response()->json($data);
    }

    public function lap_detail()
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
        return view('inventori::lap_keluar_gudang_detail', compact('data'));
    }

    public function tampil_detail(Request $request)
    {
        $dates = explode('to' ,$request->tanggal);
        $data = new \stdClass();
        $data->transaksi_rekap = DB::table('rekap_tf_gudang')
            ->join('users', 'users_id', 'rekap_beli_created_by')
            ->join('m_w', 'm_w_id', 'rekap_tf_gudang_m_w_id')
            ->join('m_gudang', 'm_gudang_code', 'rekap_tf_gudang_code')
            ->where('rekap_tf_gudang_m_w_id', $request->waroeng);
                if($request->pengadaan != 'all'){
                    $data->transaksi_rekap->where('rekap_tf_gudang_created_by', $request->pengadaan);
                }
            $data->transaksi_rekap2 = $data->transaksi_rekap->whereBetween('rekap_tf_gudang_tgl_keluar', $dates)
                ->select(DB::raw('sum(rekap_beli_detail_subtot) as total'), 'rekap_tf_gudang_code', 'm_gudang_nama', 'rekap_tf_gudang_tgl_keluar', 'name', 'rekap_tf_gudang_m_produk_nama', 'rekap_tf_gudang_qty_keluar', 'rekap_tf_gudang_hpp', 'rekap_beli_detail_subtot')
                ->orderby('rekap_tf_gudang_tgl_keluar', 'ASC')
                ->orderby('rekap_tf_gudang_code', 'ASC')
                ->get();
       
        return response()->json($data);
    }

    public function lap_rekap()
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
        return view('inventori::lap_keluar_gudang_rekap', compact('data'));
    }

    public function lap_harian()
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
        return view('inventori::lap_keluar_gudang_harian', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('inventori::edit');
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
