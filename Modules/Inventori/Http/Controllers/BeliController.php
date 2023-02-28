<?php

namespace Modules\Inventori\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
    {   
        $data = new \stdClass();
        $get_max_id = DB::table('rekap_beli')->orderBy('rekap_beli_id','desc')->first();
        $user = Auth::id();
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama')->where('m_w_id',Auth::user()->waroeng_id)->first();
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $data->gudang = DB::table('m_gudang')
        ->where('m_gudang_m_w_id',Auth::user()->waroeng_id)
        ->whereNotIn('m_gudang_nama',['gudang produksi waroeng'])
        ->get(); 
        $data->code = (empty($get_max_id->rekap_beli_id)) ? $urut = "1000001". $user : $urut = substr($get_max_id->rekap_beli_code,0,-1)+'1'. $user; 
        return view('inventori::form_beli',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function list()
    {
        $data = new \stdClass();
        $nama_barang = DB::table('m_produk')
        ->select('m_produk_code','m_produk_nama')->whereNotIn('m_produk_m_klasifikasi_produk_id',[4])->get();
        $supplierku = DB::table('m_supplier')->get();
        $satuan = DB::table('m_satuan')->get();
        foreach ($nama_barang as $key => $v) {
            $data->barang[$v->m_produk_code]=$v->m_produk_nama;
        }
        foreach ($supplierku as $key => $v) {
            $data->supplier[$v->m_supplier_code]=$v->m_supplier_nama;
        }
        foreach ($satuan as $key => $v) {
            $data->satuan[$v->m_satuan_id]=$v->m_satuan_kode;
        }
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function simpan(Request $request)
    {   $terbayar = (empty($request->rekap_beli_terbayar)) ? 0 : $request->rekap_beli_terbayar;
        $ongkir  = (empty($request->rekap_beli_ongkir)) ? 0 : $request->rekap_beli_ongkir;
        $rekap_beli = array(
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
            'rekap_beli_disc_rp' => $request->rekap_beli_disc_rp,
            'rekap_beli_ppn' => $request->rekap_beli_ppn,
            'rekap_beli_ppn_rp' => $request->rekap_beli_ppn_rp,
            'rekap_beli_ongkir' => $ongkir,
            'rekap_beli_terbayar' => $terbayar,
            'rekap_beli_tersisa' => $request->rekap_beli_tersisa,
            'rekap_beli_tot_nom' => $request->rekap_beli_tot_nom,
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
                'rekap_beli_detail_id' => $this->getlast('rekap_beli_detail','rekap_beli_detail_id'),
                'rekap_beli_detail_rekap_beli_code'=> $request->rekap_beli_code,
                'rekap_beli_detail_m_produk_code' => $request->rekap_beli_detail_m_produk_id[$key],
                'rekap_beli_detail_m_produk_nama' => $produk->m_stok_produk_nama,
                'rekap_beli_detail_satuan_id' => $produk->m_stok_satuan_id,
                'rekap_beli_detail_satuan_terima' => $produk->m_stok_satuan,
                'rekap_beli_detail_catatan' => $request->rekap_beli_detail_catatan[$key],
                'rekap_beli_detail_qty' => $request->rekap_beli_detail_qty[$key],
                'rekap_beli_detail_harga' => $request->rekap_beli_detail_harga[$key],
                'rekap_beli_detail_disc' => $request->rekap_beli_detail_disc[$key],
                'rekap_beli_detail_discrp' => $request->rekap_beli_detail_discrp[$key],
                'rekap_beli_detail_subtot' => $request->rekap_beli_detail_subtot[$key],
                'rekap_beli_detail_m_w_id' => Auth::user()->waroeng_id,
                'rekap_beli_detail_created_by' => Auth::id(),
                'rekap_beli_detail_created_at' => Carbon::now()
            );
            DB::table('rekap_beli_detail')->insert($data);
        }
        return redirect()->back()->with('success', 'your message,here'); 
    }
    public function select(Request $request)
    {
        
       $data = DB::table('m_produk')->whereNotIn('m_produk_id',$request->id)
       ->select('m_produk_id','m_produk_nama')->get();
       foreach ($data as $key => $value) {
        $list[$value->m_produk_id]=$value->m_produk_nama;
       }
       return response()->json($list);
    }
}
