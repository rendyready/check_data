<?php

namespace Modules\Inventori\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class PenjualanInternalController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = new \stdClass();
        $user = Auth::id();
        $waroeng_id = Auth::user()->waroeng_id;
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama')->where('m_w_id',$waroeng_id)->first();
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $data->gudang = DB::table('m_gudang')
        ->where('m_gudang_m_w_id',Auth::user()->waroeng_id)
        ->whereNotIn('m_gudang_nama',['gudang produksi waroeng'])
        ->get(); 
        $data->code = $this->getNextId('rekap_beli',$waroeng_id);
        $data->waroeng = DB::table('m_w')->select('m_w_code','m_w_nama')->get(); 
        return view('inventori::form_penjualan_internal',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function simpan()
    {
        $terbayar = (empty($request->rekap_beli_terbayar)) ? 0 : $request->rekap_beli_terbayar;
        $ongkir  = (empty($request->rekap_beli_ongkir)) ? 0 : $request->rekap_beli_ongkir;
        $rekap_beli = array(
            'rekap_beli_id' => $this->getMasterId('rekap_beli'),
            'rekap_beli_code' => $request->rekap_beli_code,
            'rekap_beli_code_nota' => $request->rekap_beli_code_nota,
            'rekap_beli_tgl' => $request->rekap_beli_tgl,
            'rekap_beli_jth_tmp' => $request->rekap_beli_jth_tmp,
            'rekap_beli_supplier_code' => $request->rekap_beli_supplier_code,
            'rekap_beli_supplier_nama' => $request->rekap_beli_supplier_nama,
            'rekap_beli_supplier_telp' => $request->rekap_beli_supplier_telp,
            'rekap_beli_supplier_alamat' => $request->rekap_beli_supplier_alamat,
            'rekap_beli_m_w_id' => Auth::user()->waroeng_id,
            'rekap_beli_gudang_code' => $request->rekap_beli_gudang_code,
            'rekap_beli_waroeng' => $request->rekap_beli_waroeng,
            'rekap_beli_disc' => $request->rekap_beli_disc,
            'rekap_beli_disc_rp' => convertfloat($request->rekap_beli_disc_rp),
            'rekap_beli_ppn' => $request->rekap_beli_ppn,
            'rekap_beli_ppn_rp' => convertfloat($request->rekap_beli_ppn_rp),
            'rekap_beli_ongkir' => convertfloat($ongkir),
            'rekap_beli_terbayar' => convertfloat($terbayar),
            'rekap_beli_tersisa' => convertfloat($request->rekap_beli_tersisa),
            'rekap_beli_tot_nom' => convertfloat($request->rekap_beli_tot_nom),
            'rekap_beli_created_at' => Carbon::now(),
            'rekap_beli_created_by' => Auth::id()
        );

        $insert = DB::table('rekap_beli')->insert($rekap_beli);
        foreach ($request->rekap_beli_detail_qty as $key => $value) {
            $produk = DB::table('m_stok')
            ->where('m_stok_m_produk_code',$request->rekap_beli_detail_m_produk_id[$key])
            ->where('m_stok_gudang_code',$request->rekap_beli_gudang_code)
            ->first();
            $data = array(
                'rekap_beli_detail_id' => $this->getMasterId('rekap_beli_detail'),
                'rekap_beli_detail_rekap_beli_code'=> $request->rekap_beli_code,
                'rekap_beli_detail_m_produk_code' => $request->rekap_beli_detail_m_produk_id[$key],
                'rekap_beli_detail_m_produk_nama' => $produk->m_stok_produk_nama,
                'rekap_beli_detail_satuan_id' => $produk->m_stok_satuan_id,
                'rekap_beli_detail_satuan_terima' => $produk->m_stok_satuan,
                'rekap_beli_detail_catatan' => $request->rekap_beli_detail_catatan[$key],
                'rekap_beli_detail_qty' => convertfloat($request->rekap_beli_detail_qty[$key]),
                'rekap_beli_detail_harga' => convertfloat($request->rekap_beli_detail_harga[$key]),
                'rekap_beli_detail_disc' => $request->rekap_beli_detail_disc[$key],
                'rekap_beli_detail_discrp' => convertfloat($request->rekap_beli_detail_discrp[$key]),
                'rekap_beli_detail_subtot' => convertfloat($request->rekap_beli_detail_subtot[$key]),
                'rekap_beli_detail_m_w_id' => Auth::user()->waroeng_id,
                'rekap_beli_detail_created_by' => Auth::id(),
                'rekap_beli_detail_created_at' => Carbon::now()
            );
            DB::table('rekap_beli_detail')->insert($data);
        }
        return redirect()->back()->with('success', 'your message,here'); 
    }
}
