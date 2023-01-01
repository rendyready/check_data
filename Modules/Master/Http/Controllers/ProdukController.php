<?php

namespace Modules\Master\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use illuminate\Support\Str;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = new \stdClass();
        $data->produk = DB::table('m_produk')
            ->leftjoin('m_jenis_produk', 'm_produk_m_jenis_produk_id', 'm_jenis_produk_id')
            ->leftjoin('m_satuan', 'm_produk_m_satuan_id', 'm_satuan_id')
            ->leftjoin('m_klasifikasi_produk', 'm_produk_m_klasifikasi_produk_id', 'm_klasifikasi_produk_id')
            ->get();
        $data->satuan = DB::table('m_satuan')->get();
        $data->klasifikasi = DB::table('m_klasifikasi_produk')->get();
        $data->jenisproduk = DB::table('m_jenis_produk')->get();
        $data->plot_produksi = DB::table('m_plot_produksi')->get();
        return view('master::m_produk', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function simpan(request $request)
    {
        if ($request->ajax()) {
            $produkCode = Str::lower(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $request->m_produk_code));
            $produkNama = Str::lower(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $request->m_produk_nama));
            // $produkUrut = Str::upper(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $request->m_produk_urut));
            $check = DB::table('m_produk')
                ->selectRaw('m_produk_code,m_produk_urut')
                ->selectRaw('m_produk_nama')
                ->whereRaw('LOWER(m_produk_code)=' . "'$produkCode'")
            // ->whereRaw('LOWER(m_produk_urut)=' . "'$produkUrut'")
                ->whereRaw('LOWER(m_produk_nama)=' . "'$produkNama'")
                ->orderBy('m_produk_id', 'asc')
                ->first();
            if ($request->action == 'add') {
                if (!empty($check)) {
                    return response()->json(['messages' => 'Data Simpan Double !', 'type' => 'danger']);
                } else {
                    DB::table('m_produk')->insert([
                        "m_produk_code" => Str::lower($request->m_produk_code),
                        "m_produk_nama" => $request->m_produk_nama,
                        "m_produk_urut" => $request->m_produk_urut,
                        "m_produk_cr" => $request->m_produk_cr,
                        "m_produk_status" => $request->m_produk_status,
                        "m_produk_tax" => $request->m_produk_tax,
                        "m_produk_sc" => $request->m_produk_sc,
                        "m_produk_m_jenis_produk_id" => $request->m_produk_m_jenis_produk_id,
                        "m_produk_m_satuan_id" => $request->m_produk_m_satuan_id,
                        "m_produk_m_plot_produksi_id" => $request->m_produk_m_plot_produksi_id,
                        "m_produk_m_klasifikasi_produk_id" => $request->m_produk_m_klasifikasi_produk_id,
                        "m_produk_jual" => $request->m_produk_jual,
                        "m_produk_scp" => $request->m_produk_scp,
                        "m_produk_hpp" => $request->m_produk_hpp,
                        "m_produk_created_by" => Auth::id(),
                        "m_produk_created_at" => Carbon::now(),
                    ]);
                    return response(['Messages' => 'Berhasil Tambah Produk !', 'type' => 'success']);
                }
            } else {
                if (!empty($check)) {
                    return response()->json(['messages' => 'Data Edit Double !', 'type' => 'danger']);
                } elseif ($check == null) {
                    DB::table('m_produk')->where('m_produk_id', $request->m_produk_id)
                        ->update([
                            "m_produk_code" => $produkCode,
                            "m_produk_nama" => $produkNama,
                            "m_produk_urut" => $produkUrut,
                            "m_produk_cr" => $request->m_produk_cr,
                            "m_produk_status" => $request->m_produk_status,
                            "m_produk_tax" => $request->m_produk_tax,
                            "m_produk_sc" => $request->m_produk_sc,
                            "m_produk_m_jenis_produk_id" => $request->m_produk_m_jenis_produk_id,
                            "m_produk_m_satuan_id" => $request->m_produk_m_satuan_id,
                            "m_produk_m_plot_produksi_id" => $request->m_produk_m_plot_produksi_id,
                            "m_produk_m_klasifikasi_produk_id" => $request->m_produk_m_klasifikasi_produk_id,
                            "m_produk_jual" => $request->m_produk_jual,
                            "m_produk_scp" => $request->m_produk_scp,
                            "m_produk_hpp" => $request->m_produk_hpp,
                            "m_produk_updated_by" => Auth::id(),
                            "m_produk_updated_at" => Carbon::now(),
                        ]);
                        return response(['Messages' => 'Berhasil Edit Produk !', 'type' => 'success']);
                }
            }
            
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    function list($id) {
        $data = DB::table('m_produk')->where('m_produk_id', $id)->first();
        return response()->json($data, 200);
    }
}
