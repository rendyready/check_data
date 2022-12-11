<?php

namespace Modules\Inventori\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class BeliController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {   $data = new \stdClass();
        
        $get_max_id = DB::table('rekap_beli')->orderBy('rekap_beli_id','desc')->first();
        $user = Auth::id();
        $data->code = (empty($get_max_id->rekap_beli_id)) ? $urut = "10000001". $user : $urut = substr($get_max_id->rekap_beli_code,0,-1)+'1'. $user; 
        return view('inventori::form_beli',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function list()
    {
        $data = new \stdClass();
        $nama_barang = DB::table('m_produk')->where('m_produk_m_klasifikasi_produk_id','1')
        ->select('m_produk_id','m_produk_nama')->get();
        foreach ($nama_barang as $key => $v) {
            $data->barang[$v->m_produk_id]=$v->m_produk_nama;
        }
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function simpan(Request $request)
    {
        $rekap_beli = array(
            'rekap_beli_code' => $request->rekap_beli_code,
            'rekap_beli_code_nota' => $request->rekap_beli_code_nota,
            'rekap_beli_tgl' => $request->rekap_beli_tgl,
            'rekap_beli_jth_tmp' => $request->rekap_beli_jth_tmp,
            'rekap_beli_supplier_id' => $request->rekap_beli_supplier_id,
            'rekap_beli_supplier_nama' => $request->rekap_beli_supplier_nama,
            'rekap_beli_supplier_telp' => $request->rekap_beli_supplier_telp,
            'rekap_beli_supplier_alamat' => $request->rekap_beli_supplier_alamat,
            'rekap_beli_m_w_id' => '1',
            'rekap_beli_disc' => $request->rekap_beli_disc,
            'rekap_beli_disc_rp' => $request->rekap_beli_disc_rp,
            'rekap_beli_ppn' => $request->rekap_beli_ppn,
            'rekap_beli_ppn_rp' => $request->rekap_beli_ppn_rp,
            'rekap_beli_ongkir' => $request->rekap_beli_ongkir,
            'rekap_beli_terbayar' => $request->rekap_beli_terbayar,
            'rekap_beli_tersisa' => $request->rekap_beli_tersisa,
            'rekap_beli_tot_nom' => $request->rekap_beli_tot_nom,
            'rekap_beli_created_at' => Carbon::now(),
            'rekap_beli_created_by' => Auth::id()

        );

        $insert = DB::table('rekap_beli')->insert($rekap_beli);
        foreach ($request->rekap_beli_detail_qty as $key => $value) {
            $data = array(
                'rekap_beli_detal_rekap_beli_id'=> $request->rekap_beli_code[$key],
                'rekap_beli_detail_m_produk_id' => $request->rekap_beli_detail_m_produk_id[$key],
                'rekap_beli_detail_m_produk_code' => "code",
                'rekap_beli_detail_m_produk_nama' => "nama",
                'rekap_beli_detail_qty' => $request->rekap_beli_detail_qty[$key],
                'rekap_beli_detail_satuan' => $request->rekap_beli_detail_catatan[$key],
                'rekap_beli_detail_harga' => $request->rekap_beli_detail_harga[$key],
                'rekap_beli_detail_disc' => $request->rekap_beli_detail_disc[$key],
                'rekap_beli_detail_discrp' => $request->rekap_beli_detail_discrp[$key],
                'rekap_beli_detail_subtot' => $request->rekap_beli_detail_subtot[$key],
                'rekap_beli_detail_catatan' => $request->rekap_beli_detail_catatan[$key],
                'rekap_beli_detail_created_by' => Auth::id(),
                'rekap_beli_detail_created_at' => Carbon::now()
            );
            DB::table('rekap_beli_detail')->insert($data);
        }
        return redirect()->back()->with('success', 'your message,here'); 
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
