<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
            ->leftjoin('m_satuan', 'm_produk_utama_m_satuan_id', 'm_satuan_id')
            ->leftjoin('m_klasifikasi_produk', 'm_produk_m_klasifikasi_produk_id', 'm_klasifikasi_produk_id')
            ->whereIn('m_produk_m_klasifikasi_produk_id', [4])
            ->get();
        $data->satuan = DB::table('m_satuan')->get();
        $data->klasifikasi = DB::table('m_klasifikasi_produk')->where('m_klasifikasi_produk_id', 4)->get();
        $data->jenisproduk = DB::table('m_jenis_produk')->get();
        $data->plot_produksi = DB::table('m_plot_produksi')->get();
        $data->subjenis = DB::table('m_sub_jenis_produk')->get();
        return view('master::m_produk', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function simpan(request $request)
    {
        if ($request->ajax()) {
            $produkNama = Str::lower(preg_replace(array('/\s{2,}/', '/[\t\n]/', '/[^A-Za-z0-9]/'), ' ', $request->m_produk_nama));
            $produkNamaCR = Str::lower(preg_replace(array('/\s{2,}/', '/[\t\n]/', '/[^A-Za-z0-9]/'), ' ', $request->m_produk_cr));
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
                    $produk_code = DB::table('m_klasifikasi_produk')->where('m_klasifikasi_produk_id', 4)->first();
                    $kat = $request->m_produk_m_klasifikasi_produk_id;
                    $num = $produk_code->m_klasifikasi_produk_last_id + 1;
                    $code = $produk_code->m_klasifikasi_produk_prefix . '-' . $kat . str_pad($num, 5, "0", STR_PAD_LEFT);

                    $file = $this->upload_file($request);
                    $link = $this->uploadImageCloud($file);
                    $url = ($link) ? $link : 'https://placehold.co/400x400/000000/FFF' ;

                    DB::table('m_produk')->insert([
                        "m_produk_id" => '1',
                        "m_produk_code" => $code,
                        "m_produk_nama" => $produkNama,
                        "m_produk_urut" => $request->m_produk_urut,
                        "m_produk_cr" => $produkNamaCR,
                        "m_produk_status" => $request->m_produk_status,
                        "m_produk_tax" => $request->m_produk_tax,
                        "m_produk_sc" => $request->m_produk_sc,
                        "m_produk_m_jenis_produk_id" => $request->m_produk_m_jenis_produk_id,
                        "m_produk_utama_m_satuan_id" => $request->m_produk_utama_m_satuan_id,
                        "m_produk_isi_m_satuan_id" => $request->m_produk_isi_m_satuan_id,
                        "m_produk_m_plot_produksi_id" => $request->m_produk_m_plot_produksi_id,
                        "m_produk_m_klasifikasi_produk_id" => $request->m_produk_m_klasifikasi_produk_id,
                        "m_produk_jual" => $request->m_produk_jual,
                        "m_produk_scp" => $request->m_produk_scp,
                        "m_produk_hpp" => $request->m_produk_hpp,
                        "m_produk_created_by" => Auth::user()->users_id,
                        "m_produk_created_at" => Carbon::now(),
                        "m_produk_image" => $url,
                    ]);
                    DB::table('m_klasifikasi_produk')->where('m_klasifikasi_produk_id', $kat)->update(['m_klasifikasi_produk_last_id' => $num]);
                    $get_last_produk = DB::table('m_produk')->orderBy('m_produk_id', 'desc')->first();

                    if ($get_last_produk) {
                        $get_last_produk_id = $get_last_produk->m_produk_id;

                        if ($request->config_sub_jenis_produk_m_sub_jenis_produk_id) {
                            foreach ($request->config_sub_jenis_produk_m_sub_jenis_produk_id as $value) {
                                DB::table('config_sub_jenis_produk')->insert([
                                    "config_sub_jenis_produk_id" => '1',
                                    "config_sub_jenis_produk_m_produk_id" => $get_last_produk_id,
                                    "config_sub_jenis_produk_m_sub_jenis_produk_id" => $value,
                                    "config_sub_jenis_produk_created_by" => Auth::user()->users_id,
                                    "config_sub_jenis_produk_created_at" => Carbon::now(),
                                ]);
                            }
                        }
                    }

                    if ($request->m_produk_m_jenis_produk_id == 11) {
                        $get_gudang = DB::table('m_gudang')->whereIn('m_gudang_nama', ['gudang wbd waroeng'])->get();
                        foreach ($get_gudang as $key) {
                            $satuan_id = $request->m_produk_utama_m_satuan_id;
                            $satuan = DB::table('m_satuan')->where('m_satuan_id', $satuan_id)->first();
                            $data_bb = array(
                                // 'm_stok_id' => $this->getMasterId('m_stok'),
                                'm_stok_id' => '1',
                                'm_stok_m_produk_code' => $code,
                                'm_stok_produk_nama' => strtolower($request->m_produk_nama),
                                'm_stok_gudang_code' => $key->m_gudang_code,
                                'm_stok_waroeng' => $key->m_gudang_m_w_nama,
                                'm_stok_satuan_id' => $satuan_id,
                                'm_stok_satuan' => $satuan->m_satuan_kode,
                                'm_stok_awal' => 0,
                                'm_stok_created_by' => Auth::user()->users_id,
                                'm_stok_created_at' => Carbon::now(),
                            );
                            DB::table('m_stok')->insert($data_bb);
                        }
                    }
                    return response(['messages' => 'Berhasil Tambah Produk !', 'type' => 'success']);
                }
            } else {
                if ($request->m_produk_id == null) {
                    return response()->json(['messages' => 'Data Edit Double !', 'type' => 'danger']);
                } else {
                    $file = $this->upload_file($request);
                    $link = $this->uploadImageCloud($file);
                    $this->remove_file($file);
                    if ($link) {
                        $data = [
                            "m_produk_nama" => $produkNama,
                            "m_produk_urut" => $request->m_produk_urut,
                            "m_produk_cr" => $produkNamaCR,
                            "m_produk_status" => $request->m_produk_status,
                            "m_produk_tax" => $request->m_produk_tax,
                            "m_produk_sc" => $request->m_produk_sc,
                            "m_produk_m_jenis_produk_id" => $request->m_produk_m_jenis_produk_id,
                            "m_produk_utama_m_satuan_id" => $request->m_produk_utama_m_satuan_id,
                            "m_produk_m_plot_produksi_id" => $request->m_produk_m_plot_produksi_id,
                            "m_produk_m_klasifikasi_produk_id" => $request->m_produk_m_klasifikasi_produk_id,
                            "m_produk_jual" => $request->m_produk_jual,
                            "m_produk_scp" => $request->m_produk_scp,
                            "m_produk_hpp" => $request->m_produk_hpp,
                            "m_produk_status_sync" => 'send',
                            "m_produk_client_target" => DB::raw('DEFAULT'),
                            "m_produk_updated_by" => Auth::user()->users_id,
                            "m_produk_updated_at" => Carbon::now(),
                            "m_produk_image" => $link,
                        ];
                    } else {
                        $data = [
                            "m_produk_nama" => $produkNama,
                            "m_produk_urut" => $request->m_produk_urut,
                            "m_produk_cr" => $produkNamaCR,
                            "m_produk_status" => $request->m_produk_status,
                            "m_produk_tax" => $request->m_produk_tax,
                            "m_produk_sc" => $request->m_produk_sc,
                            "m_produk_m_jenis_produk_id" => $request->m_produk_m_jenis_produk_id,
                            "m_produk_utama_m_satuan_id" => $request->m_produk_utama_m_satuan_id,
                            "m_produk_m_plot_produksi_id" => $request->m_produk_m_plot_produksi_id,
                            "m_produk_m_klasifikasi_produk_id" => $request->m_produk_m_klasifikasi_produk_id,
                            "m_produk_jual" => $request->m_produk_jual,
                            "m_produk_scp" => $request->m_produk_scp,
                            "m_produk_hpp" => $request->m_produk_hpp,
                            "m_produk_status_sync" => 'send',
                            "m_produk_client_target" => DB::raw('DEFAULT'),
                            "m_produk_updated_by" => Auth::user()->users_id,
                            "m_produk_updated_at" => Carbon::now(),
                        ];
                    }

                    DB::table('m_produk')
                        ->where('m_produk_id', $request->m_produk_id)
                        ->update($data);
                    

                    if ($request->config_sub_jenis_produk_m_sub_jenis_produk_id) {
                        foreach ($request->config_sub_jenis_produk_m_sub_jenis_produk_id as $value) {
                            $existingData = DB::table('config_sub_jenis_produk')
                                ->where('config_sub_jenis_produk_m_produk_id', $request->m_produk_id)
                                ->where('config_sub_jenis_produk_m_sub_jenis_produk_id', $request->config_sub_jenis_produk_m_sub_jenis_produk_id)
                                ->first();
                            if ($existingData) {
                                DB::table('config_sub_jenis_produk')
                                    ->where('config_sub_jenis_produk_id', $existingData->config_sub_jenis_produk_id)
                                    ->update([
                                        "config_sub_jenis_produk_m_sub_jenis_produk_id" => $value,
                                        "config_sub_jenis_produk_updated_by" => Auth::user()->users_id,
                                        "config_sub_jenis_produk_updated_at" => Carbon::now(),
                                    ]);
                            }
                        }
                    }

                    return response(['messages' => 'Berhasil Edit Produk !', 'type' => 'success']);
                }
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function list($id)
    {
        $data_produk = DB::table('m_produk')->where('m_produk_id', $id)->first();
        $data_sub_jenis_produk = DB::table('config_sub_jenis_produk')
            ->where('config_sub_jenis_produk_m_produk_id', $id)
            ->pluck('config_sub_jenis_produk_m_sub_jenis_produk_id')
            ->toArray();
        return response()->json([
            'data_produk' => $data_produk,
            'data_sub_jenis_produk' => $data_sub_jenis_produk,
        ], 200);
    }

    public function get_prod_sat($id)
    {
        $satuan_bb = DB::table('m_produk')->where('m_produk_code', $id)
            ->join('m_satuan', 'm_satuan_id', 'm_produk_utama_m_satuan_id')
            ->first();
        return $satuan_bb;
    }
}
