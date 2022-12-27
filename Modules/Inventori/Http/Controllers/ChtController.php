<?php

namespace Modules\Inventori\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class ChtController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {   
        $data = new \stdClass();
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $waroeng_id = Auth::user()->waroeng_id;
        $data->nama_waroeng = DB::table('m_w')->select('m_w_nama')->where('m_w_id',$waroeng_id)->first();
        $data->satuan = DB::table('m_satuan')->get();
        $data->cht = DB::table('rekap_beli_detail')
        ->select('rekap_beli_detail_id','rekap_beli_detail_m_produk_id','rekap_beli_supplier_nama','rekap_beli_detail_m_produk_nama',
                 'rekap_beli_detail_catatan','rekap_beli_detail_qty','m_satuan_kode')
        ->leftjoin('rekap_beli','rekap_beli_code','rekap_beli_detail_rekap_beli_code')
        ->leftjoin('m_produk','rekap_beli_detail_m_produk_id','m_produk_id')
        ->leftjoin('m_satuan','m_produk_m_satuan_id','m_satuan_id')
        ->where('rekap_beli_tgl',$data->tgl_now)
        ->where('rekap_beli_m_w_id',$waroeng_id)
        ->whereNull('rekap_beli_detail_terima')
        ->get();
        return view('inventori::form_cht',compact('data'));
    }
    public function simpan(Request $request)
    {   $waroeng_id = Auth::user()->waroeng_id;
        foreach ($request->rekap_beli_detail_id as $key => $value) {
            $save_beli = DB::table('rekap_beli_detail')
                ->where('rekap_beli_detail_id',$request->rekap_beli_detail_id[$key])
                ->update(['rekap_beli_detail_terima'=>$request->rekap_beli_detail_terima[$key],
                          'rekap_beli_detail_satuan_terima' => $request->rekap_beli_detail_satuan_terima[$key]]);
            if (empty($request->rekap_beli_detail_terima[$key])) {
                $saldo = DB::table('m_stok_mutasi')
                ->where('m_stok_mutasi_m_w_id',$waroeng_id)
                ->where('m_stok_mutasi_gudang','gudang utama')
                ->where('m_stok_mutasi_m_produk_id',$request->rekap_beli_detail_m_produk_id[$key])
                ->sortBy('m_stok_mutasi_id','desc')
                ->first();
                $last_saldo = (empty($saldo->m_stok_mutasi_saldo)) ? $saldo->m_stok_mutasi_stok_awal : $saldo->m_stok_mutasi_saldo ;
                $data = array(
                    'm_stok_mutasi_m_produk_id' => $request->rekap_beli_detail_m_produk_id[$key],
                    'm_stok_mutasi_m_produk_nama' => $request->rekap_beli_detail_m_produk_nama[$key],
                    'm_stok_mutasi_satuan' => $request->rekap_beli_detail_satuan_terima[$key],
                    'm_stok_mutasi_stok_masuk' => $request->rekap_beli_detail_terima[$key],
                    'm_stok_mutasi_saldo' = > ,
                )
            }                
        }

        return redirect()->back();
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('inventori::show');
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
