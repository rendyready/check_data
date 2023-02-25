<?php

namespace Modules\Inventori\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MStokController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {

        $gudang = DB::table('m_gudang')
            ->join('m_w', 'm_w_id', 'm_gudang_m_w_id')
            ->select('m_gudang_code', 'm_gudang_nama', 'm_w_nama')->get();
        $waroeng_id = Auth::user()->waroeng_id;
        $tgl_now = Carbon::now()->format('Y-m-d');
        return view('inventori::form_stok_awal', compact('gudang', 'tgl_now'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    function list($id) {
        $stok = DB::table('m_stok')
            ->where('m_stok_gudang_code', $id)
            ->get();
        $no = 0;
        $data = array();
        foreach ($stok as $value) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = ucwords($value->m_stok_produk_nama);
            $row[] = $value->m_stok_awal;
            $row[] = $value->m_stok_hpp;
            $row[] = $value->m_stok_satuan;
            $data[] = $row;
        }
        $output = array('data' => $data);
        return response()->json($output);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function simpan(Request $request)
    {
        $messages = ['required' => 'Gudang Wajib dipilih Dahulu !' ];
        $validated = $request->validate([
            'm_stok_gudang_code' => 'required',
        ], $messages);
        foreach ($request->m_stok_m_produk_code as $key => $value) {
            $cek = DB::table('m_stok')->where('m_stok_gudang_code', $request->m_stok_gudang_code)
                ->where('m_stok_m_produk_code', $request->m_stok_m_produk_code[$key])->first();
            $hpp = $cek->m_stok_hpp;
            $saldo = $cek->m_stok_saldo;
            $hpp_new = (($hpp*$saldo)+($request->m_stok_awal[$key]*$request->m_stok_hpp[$key]))/($saldo+$request->m_stok_awal[$key]);
                
            $data = array(
                    'm_stok_awal' => $request->m_stok_awal[$key],
                    'm_stok_hpp' => $hpp_new,
                    'm_stok_saldo' => $saldo+$request->m_stok_awal[$key],
                );
            
            DB::table('m_stok')->where('m_stok_gudang_code', $request->m_stok_gudang_code)
            ->where('m_stok_m_produk_code', $request->m_stok_m_produk_code[$key])->update($data);
            
        }
        return response()->json(['message'=>'Sukses Menambah Stok Awal','type'=>'success']);

    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function master_stok($id)
    {
       $data = DB::table('m_stok')->where('m_stok_gudang_id',$id)
        ->select('m_produk_id','m_produk_nama')
        ->join('m_produk','m_produk_id','m_stok_m_produk_code')
        ->get();
        foreach ($data as $key => $v) {
            $list[$v->m_produk_id]=$v->m_produk_nama;
        }
        return response()->json($list);
    }
    public function get_harga($id_g,$id_p)
    {
        $data = DB::table('m_stok')
                ->where('m_stok_gudang_id',$id_g)
                ->where('m_stok_m_produk_code',$id_p)
        ->first();
        return response()->json($data);
    }
}
