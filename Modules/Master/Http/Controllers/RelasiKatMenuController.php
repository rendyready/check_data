<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class RelasiKatMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = new \stdClass();
        $data->relasi = DB::table('config_sub_jenis_produk')
            ->leftjoin('m_produk', 'config_sub_jenis_produk_m_produk_id', 'm_produk_id')
            ->leftjoin('m_sub_jenis_produk', 'config_sub_jenis_produk_m_sub_jenis_produk_id', 'm_sub_jenis_produk_id')
            ->get();
        $data->produk = DB::table('m_produk')->where('m_produk_m_klasifikasi_produk_id', 4)->get();
        $data->kategori = DB::table('m_sub_jenis_produk')->get();
        return view('master::m_produk_relasi', compact('data'));
    }
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function simpan(Request $request)
    {
        $config_sub_jenis_produk_m_produk_id = $request->config_sub_jenis_produk_m_produk_id;
        $config_sub_jenis_produk_m_kategori_ids = $request->config_sub_jenis_produk_m_kategori_id;
        foreach ($config_sub_jenis_produk_m_kategori_ids as $config_sub_jenis_produk_m_kategori_id) {
            $existingData = DB::table('config_sub_jenis_produk')
                ->where('config_sub_jenis_produk_m_produk_id', $config_sub_jenis_produk_m_produk_id)
                ->where('config_sub_jenis_produk_m_sub_jenis_produk_id', $config_sub_jenis_produk_m_kategori_id)
                ->first();
            if ($existingData) {
                DB::table('config_sub_jenis_produk')
                    ->where('config_sub_jenis_produk_id', $existingData->config_sub_jenis_produk_id)
                    ->update([
                        "config_sub_jenis_produk_id" => '1',
                        "config_sub_jenis_produk_m_sub_jenis_produk_id" => $config_sub_jenis_produk_m_kategori_id,
                        "config_sub_jenis_produk_updated_by" => Auth::user()->users_id,
                        "config_sub_jenis_produk_updated_at" => Carbon::now(),
                    ]);
            } else {
                DB::table('config_sub_jenis_produk')->insert([
                    "config_sub_jenis_produk_id" => '1',
                    "config_sub_jenis_produk_m_produk_id" => $config_sub_jenis_produk_m_produk_id,
                    "config_sub_jenis_produk_m_sub_jenis_produk_id" => $config_sub_jenis_produk_m_kategori_id,
                    "config_sub_jenis_produk_created_by" => Auth::user()->users_id,
                    "config_sub_jenis_produk_created_at" => Carbon::now(),
                ]);
            }
        }

        return Redirect::route('m_produk_relasi.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    function list($id) {
        $data = DB::table('config_sub_jenis_produk')->where('config_sub_jenis_produk_id', $id)->first();
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(request $request)
    {
        $data = DB::table('config_sub_jenis_produk')->where('config_sub_jenis_produk_id', $request->id)->update([
            "config_sub_jenis_produk_m_produk_id" => $request->config_sub_jenis_produk_m_produk_id,
            "config_sub_jenis_produk_m_sub_jenis_produk_id" => $request->config_sub_jenis_produk_m_kategori_id,
            "config_sub_jenis_produk_status_sync" => "send",
            'config_sub_jenis_produk_client_target' => DB::raw('DEFAULT'),
            "config_sub_jenis_produk_updated_by" => Auth::user()->users_id,
            "config_sub_jenis_produk_updated_at" => Carbon::now(),
        ]);
        return Redirect::route('m_produk_relasi.index');
    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function hapus($id)
    {
        $data = DB::table('config_sub_jenis_produk')->where('config_sub_jenis_produk_id', '=', $id)->delete();
        return Redirect::route('m_produk_relasi.index');
    }
}
