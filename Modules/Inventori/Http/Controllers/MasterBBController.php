<?php

namespace Modules\Inventori\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use illuminate\Support\Str;
use Carbon\Carbon;
class MasterBBController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = new \stdClass();
        $data->produk = DB::table('m_produk')
            ->select(
                'm_produk_code','m_produk_nama','m_produk_status','m_produk_id','m_klasifikasi_produk_nama',
                'ms1.m_satuan_kode as satuan_utama','ms2.m_satuan_kode as satuan_produksi')
            ->leftjoin('m_jenis_produk', 'm_produk_m_jenis_produk_id', 'm_jenis_produk_id')
            ->leftjoin('m_satuan as ms1', 'm_produk_utama_m_satuan_id', 'ms1.m_satuan_id')
            ->leftjoin('m_satuan as ms2', 'm_produk_isi_m_satuan_id', 'ms2.m_satuan_id')
            ->join('m_klasifikasi_produk', 'm_produk_m_klasifikasi_produk_id', 'm_klasifikasi_produk_id')
            ->whereNotIn('m_produk_m_klasifikasi_produk_id',[4])
            ->get();
        $data->satuan = DB::table('m_satuan')->get();
        $data->klasifikasi = DB::table('m_klasifikasi_produk')->whereNotIn('m_klasifikasi_produk_id',[4])->get();
        $data->jenisproduk = DB::table('m_jenis_produk')->get();
        $data->plot_produksi = DB::table('m_plot_produksi')->get();
        return view('inventori::m_bb', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function simpan(request $request)
    {
        if ($request->ajax()) {
            $produkNama = Str::lower(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $request->m_produk_nama));
            $produkUrut = Str::upper(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $request->m_produk_urut));
            $check = DB::table('m_produk')
                ->select('m_produk_id')
                ->selectRaw('m_produk_code,m_produk_urut')
                ->selectRaw('m_produk_nama')
                ->whereRaw('LOWER(m_produk_urut)=' . "'$produkUrut'")
                ->whereRaw('LOWER(m_produk_nama)=' . "'$produkNama'")
                ->orderBy('m_produk_id', 'asc')
                ->first();
            if ($request->action == 'add') {
                if (!empty($check)) {
                    return response()->json(['messages' => 'Data Simpan Double !', 'type' => 'danger']);
                } else {
                    $produk_code = DB::table('m_produk_code')->where('m_produk_code_id',1)->first();
                    $kat = $request->m_produk_m_klasifikasi_produk_id;
                    if ($kat == 1) {
                        $code = 'tl-'.$produk_code->m_produk_code_tl+1 ;
                        $row = 'm_produk_code_tl';
                        $urut = $produk_code->m_produk_code_tl+1 ;   
                    } elseif($kat == 2) {
                        $code = 'bo-'.$produk_code->m_produk_code_bo+1 ;
                        $row = 'm_produk_code_bo';
                        $urut = $produk_code->m_produk_code_bo+1 ;
                    } else {
                        $code = 'bb-'.$produk_code->m_produk_code_bb+1 ;
                        $row = 'm_produk_code_bb';
                        $urut = $produk_code->m_produk_code_bb+1 ;
                    }
                    DB::table('m_produk')->insert([
                        "m_produk_code" => $code,
                        "m_produk_nama" => $request->m_produk_nama,
                        "m_produk_status" => $request->m_produk_status,
                        "m_produk_utama_m_satuan_id" => $request->m_produk_utama_m_satuan_id,
                        "m_produk_isi_m_satuan_id" => $request->m_produk_isi_m_satuan_id,
                        "m_produk_m_klasifikasi_produk_id" => $request->m_produk_m_klasifikasi_produk_id,
                        "m_produk_jual" => $request->m_produk_jual,
                        "m_produk_scp" => $request->m_produk_scp,
                        "m_produk_hpp" => $request->m_produk_hpp,
                        "m_produk_created_by" => Auth::id(),
                        "m_produk_created_at" => Carbon::now(),
                    ]);
                    DB::table('m_produk_code')->where('m_produk_code_id',1)->update([$row=>$urut]);
                    return response(['messages' => 'Berhasil Tambah BB !', 'type' => 'success']);
                }
            } else {
                if ($request->m_produk_id==null ) {
                    return response()->json(['messages' => 'Data Edit Double !', 'type' => 'danger']);
                } else {
                    DB::table('m_produk')->where('m_produk_id', $request->m_produk_id)
                        ->update([
                            "m_produk_nama" => $request->m_produk_nama,
                            "m_produk_status" => $request->m_produk_status,
                            "m_produk_utama_m_satuan_id" => $request->m_produk_utama_m_satuan_id,
                            "m_produk_isi_m_satuan_id" => $request->m_produk_isi_m_satuan_id,
                            "m_produk_m_klasifikasi_produk_id" => $request->m_produk_m_klasifikasi_produk_id,
                            "m_produk_jual" => $request->m_produk_jual,
                            "m_produk_scp" => $request->m_produk_scp,
                            "m_produk_hpp" => $request->m_produk_hpp,
                            "m_produk_updated_by" => Auth::id(),
                            "m_produk_updated_at" => Carbon::now(),
                        ]);
                        return response(['messages' => 'Berhasil Edit BB !', 'type' => 'success']);
                }
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    function list($id)
    {
        $data = DB::table('m_produk')->where('m_produk_id', $id)->first();
        return response()->json($data, 200);
    } 
}
