<?php

namespace Modules\Inventori\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class InvPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = new \stdClass();
        
        $get_max_id = DB::table('rekap_inv_penjualan')->orderBy('rekap_inv_penjualan_id','desc')->first();
        $user = Auth::user()->users_id;
        $data->code = (empty($get_max_id->rekap_inv_penjualan_id)) ? $urut = "20000001". $user : $urut = substr($get_max_id->rekap_inv_penjualan_code,0,-1)+'1'. $user; 
        return view('inventori::form_penjualan_umum',compact('data'));
    }

    public function simpan(Request $request)
    {
        $rekap_inv_penjualan = array(
            'rekap_inv_penjualan_code' => $request->rekap_inv_penjualan_code,
            'rekap_inv_penjualan_tgl' => $request->rekap_inv_penjualan_tgl,
            'rekap_inv_penjualan_jth_tmp' => $request->rekap_inv_penjualan_jth_tmp,
            'rekap_inv_penjualan_supplier_id' => $request->rekap_inv_penjualan_supplier_id,
            'rekap_inv_penjualan_supplier_nama' => $request->rekap_inv_penjualan_supplier_nama,
            'rekap_inv_penjualan_supplier_telp' => $request->rekap_inv_penjualan_supplier_telp,
            'rekap_inv_penjualan_supplier_alamat' => $request->rekap_inv_penjualan_supplier_alamat,
            'rekap_inv_penjualan_m_w_id' => Auth::user()->waroeng_id,
            'rekap_inv_penjualan_disc' => $request->rekap_inv_penjualan_disc,
            'rekap_inv_penjualan_disc_rp' => $request->rekap_inv_penjualan_disc_rp,
            'rekap_inv_penjualan_ppn' => $request->rekap_inv_penjualan_ppn,
            'rekap_inv_penjualan_ppn_rp' => $request->rekap_inv_penjualan_ppn_rp,
            'rekap_inv_penjualan_ongkir' => $request->rekap_inv_penjualan_ongkir,
            'rekap_inv_penjualan_terbayar' => $request->rekap_inv_penjualan_terbayar,
            'rekap_inv_penjualan_tersisa' => $request->rekap_inv_penjualan_tersisa,
            'rekap_inv_penjualan_tot_nom' => $request->rekap_inv_penjualan_tot_nom,
            'rekap_inv_penjualan_created_at' => Carbon::now(),
            'rekap_inv_penjualan_created_by' => Auth::user()->users_id

        );

        $insert = DB::table('rekap_inv_penjualan')->insert($rekap_inv_penjualan);
        foreach ($request->rekap_inv_penjualan_detail_qty as $key => $value) {
            $produk = DB::table('m_produk')
            ->where('m_produk_id',$request->rekap_inv_penjualan_detail_m_produk_id[$key])
            ->first();
            $data = array(  
                'rekap_inv_penjualan_detail_rekap_inv_penjualan_code'=> $request->rekap_inv_penjualan_code,
                'rekap_inv_penjualan_detail_m_produk_id' => $request->rekap_inv_penjualan_detail_m_produk_id[$key],
                'rekap_inv_penjualan_detail_m_produk_code' => $produk->m_produk_code,
                'rekap_inv_penjualan_detail_m_produk_nama' => $produk->m_produk_nama,
                'rekap_inv_penjualan_detail_qty' => $request->rekap_inv_penjualan_detail_qty[$key],
                'rekap_inv_penjualan_detail_satuan' => $request->rekap_inv_penjualan_detail_catatan[$key],
                'rekap_inv_penjualan_detail_harga' => $request->rekap_inv_penjualan_detail_harga[$key],
                'rekap_inv_penjualan_detail_disc' => $request->rekap_inv_penjualan_detail_disc[$key],
                'rekap_inv_penjualan_detail_discrp' => $request->rekap_inv_penjualan_detail_discrp[$key],
                'rekap_inv_penjualan_detail_subtot' => $request->rekap_inv_penjualan_detail_subtot[$key],
                'rekap_inv_penjualan_detail_catatan' => $request->rekap_inv_penjualan_detail_catatan[$key],
                'rekap_inv_penjualan_detail_created_by' => Auth::user()->users_id,
                'rekap_inv_penjualan_detail_created_at' => Carbon::now()
            );
            DB::table('rekap_inv_penjualan_detail')->insert($data);
        }
        return redirect()->back()->with('success', 'your message,here'); 
    }

}
