<?php

namespace Modules\Master\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
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


        echo "<pre>";
        dd($data);
        echo "</pre>";
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function simpan(request $request)
    {
        $raw = [
            'm_produk_code' => ['required', 'unique:m_produk', 'max:255'],
            'm_produk_nama' => ['required', 'unique:m_produk', 'max:255'],
            'm_prosuk_cr' => ['required'],
        ];
        $value = [
            "m_produk_code" => Str::lower($request->m_produk_code),
            "m_produk_nama" => Str::lower($request->m_produk_nama),
            "m_produk_cr" => Str::lower($request->m_produk_cr),
        ];
        $validate = Validator::make($value, $raw);
        if ($validate->fails()) {
            return redirect()->route('m_produk.index')
                ->withErrors($validate)
                ->withInput();
        } else {
            DB::table('m_produk')->insert([
                "m_produk_code" => Str::lower($request->m_produk_code),
                "m_produk_nama" => Str::lower($request->m_produk_nama),
                "m_produk_urut" => $request->m_produk_urut,
                "m_produk_cr" => Str::lower($request->m_produk_cr),
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
            return Redirect::route('m_produk.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function list($id)
    {
        $data = DB::table('m_produk')->where('m_produk_id', $id)->first();
        return response()->json($data, 200);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('master::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(request $request)
    {
        $rawData = [
            'm_produk_code' => ['required', 'unique:m_produk'],
            'm_produk_nama' => ['required', 'unique:m_produk', 'max:255'],
            'm_produk_cd' => ['required'],
        ];
        $value = [
            'm_produk_nama' => Str::lower($request->m_produk_nama),
            'm_produk_code' => Str::lower($request->m_produk_code),
            'm_produk_cr' => Str::lower($request->m_produk_cr),
        ];
        $validate = Validator::make($value, $rawData);
        if ($validate->fails()) {
            return redirect()->route('m_produk.index')
                ->withErrors($validate)
                ->withInput();
        } else {
            DB::table('m_produk')->where('m_produk_id', $request->m_produk_id)
                ->update([
                    "m_produk_code" => $request->m_produk_code,
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
                    "m_produk_updated_by" => Auth::id(),
                    "m_produk_updated_at" => Carbon::now(),
                ]);
        }
        return Redirect::route('m_produk.index')->with(['Success' => $validate->messages()]);
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
