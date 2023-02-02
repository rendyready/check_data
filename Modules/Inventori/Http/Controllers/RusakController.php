<?php

namespace Modules\Inventori\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class RusakController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {   $data = new \stdClass();
        $get_max_id = DB::table('rekap_rusak')->orderBy('rekap_rusak_id','desc')->first();
        $user = Auth::id();
        $w_id = Auth::user()->waroeng_id;
        $waroeng_nama = DB::table('m_w')->select('m_w_nama')->where('m_w_id',$w_id)->first();
        $data->code = (empty($get_max_id->rekap_rusak_id)) ? $urut = "500001". $user : $urut = substr($get_max_id->rekap_rusak_code,0,-1)+'1'. $user; 
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $data->gudang = DB::table('m_gudang')->select('m_gudang_id','m_gudang_nama')
        ->where('m_gudang_m_w_id',$w_id)->get();
        return view('inventori::form_rusak',compact('data','waroeng_nama'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function simpan(Request $request)
    {
        $rekap_rusak = array(
            'rekap_rusak_code' => $request->rekap_rusak_code,
            'rekap_rusak_tgl' => $request->rekap_rusak_tgl,
            'rekap_rusak_m_w_id' => Auth::user()->waroeng_id,
            'rekap_rusak_created_at' => Carbon::now(),
            'rekap_rusak_created_by' => Auth::id()
        );

        $insert = DB::table('rekap_rusak')->insert($rekap_rusak);
        foreach ($request->rekap_rusak_detail_qty as $key => $value) {
            $produk = DB::table('m_produk')
            ->where('m_produk_id',$request->rekap_rusak_detail_m_produk_id[$key])
            ->first();
            $data = array(
                'rekap_rusak_detail_rekap_rusak_code'=> $request->rekap_rusak_code,
                'rekap_rusak_detail_m_produk_id' => $request->rekap_rusak_detail_m_produk_id[$key],
                'rekap_rusak_detail_gudang_id' => $request->m_gudang_id,
                'rekap_rusak_detail_m_produk_code' => $produk->m_produk_code,
                'rekap_rusak_detail_m_produk_nama' => $produk->m_produk_nama,
                'rekap_rusak_detail_qty' => $request->rekap_rusak_detail_qty[$key],
                'rekap_rusak_detail_hpp' => $request->rekap_rusak_detail_hpp[$key],
                'rekap_rusak_detail_sub_total' => $request->rekap_rusak_detail_sub_total[$key],
                'rekap_rusak_detail_catatan' => $request->rekap_rusak_detail_catatan[$key],
                'rekap_rusak_detail_created_by' => Auth::id(),
                'rekap_rusak_detail_created_at' => Carbon::now()
            );
            DB::table('rekap_rusak_detail')->insert($data);

            $data_stok = DB::table('m_stok')
            ->where('m_stok_gudang_id',$request->m_gudang_id)
            ->where('m_stok_m_produk_id',$request->rekap_rusak_detail_m_produk_id[$key])
            ->first();
            $data2 = array( 
                            'm_stok_keluar' => $data_stok->m_stok_keluar+$request->rekap_rusak_detail_qty[$key],
                            'm_stok_saldo' => $data_stok->m_stok_saldo-$request->rekap_rusak_detail_qty[$key],
                            'm_stok_rusak' => $data_stok->m_stok_rusak+$request->rekap_rusak_detail_qty[$key]
                        );
            DB::table('m_stok')->where('m_stok_gudang_id',$request->rekap_beli_gudang_id)
            ->where('m_stok_m_produk_id',$request->rekap_rusak_detail_m_produk_id[$key])
            ->update($data2);

            $input_detail = array(
                'm_stok_detail_m_produk_id' => $request->rekap_rusak_detail_m_produk_id[$key],
                'm_stok_detail_tgl'=> Carbon::now(),
                'm_stok_detail_m_produk_nama' => $produk->m_produk_nama,
                // 'm_stok_detail_satuan' => $request->rekap_beli_detail_satuan_terima[$key],
                'm_stok_detail_keluar' => $request->rekap_rusak_detail_qty[$key],
                'm_stok_detail_saldo' => $data_stok->m_stok_saldo - $request->rekap_rusak_detail_qty[$key],
                'm_stok_detail_hpp' => $data_stok->m_stok_hpp,
                'm_stok_detail_catatan' => 'Rusak'.$request->rekap_rusak_code,
                'm_stok_detail_gudang_id' => $request->m_gudang_id,
                'm_stok_detail_created_by' => Auth::id(),
                'm_stok_detail_created_at' => Carbon::now()
            );
            DB::table('m_stok_detail')->insert($input_detail);
        }
        return redirect()->back()->with('success', 'your message,here'); 
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
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
