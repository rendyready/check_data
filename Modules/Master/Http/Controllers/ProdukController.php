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



        // echo '<pre>';
        // var_dump($data);
        // echo '</pre>';
        // Test
        $produkCode = Str::lower(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', DB::raw('Fg-11-000-018')));
        $produkNama = Str::lower(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', DB::raw('SaMBAl                    bAJaK')));
        $produkUrut = Str::lower(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', DB::raw('001-001')));
        $check = DB::table('m_produk')
            ->selectRaw('m_produk_code,m_produk_urut')
            ->selectRaw('m_produk_nama')
            ->whereRaw(
                'LOWER(m_produk_code)=' . "'$produkCode'"
            )->whereRaw(
                'LOWER(m_produk_urut)=' . "'$produkUrut'"
            )->whereRaw(
                'LOWER(m_produk_nama)=' . "'$produkNama'"
            )
            ->orderBy('m_produk_id', 'asc')
            ->get();
        if ($check == true) {
            return  ['Data' => 'Data Double Kak !', $check];
        } else {
            return  ['Data' => 'Yuk Kak !', $check];
        }

        // return $check;
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function simpan(request $request)
    {
        $produkCode = Str::upper(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $request->m_produk_code));
        $produkNama = Str::upper(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $request->m_produk_nama));
        $produkUrut = Str::upper(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $request->m_produk_urut));

        $check = DB::table('m_produk')->select('m_produk_coode', 'm_produk_nama', 'm_produk_urut') //select 
            ->where(['m_produk_code' => $produkCode] . ['m_produk_nama' => $produkNama], ['m_produk_urut' => $produkUrut]) //data
            ->whereNull('m_produk_deleted_at')
            ->orderBy('m_produk_id', 'asc')
            ->first();
        if ($check) {
            return response(['Messages' => 'Data Duplicate !']);
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
            return Redirect::route('/master/produk/edit');
            return response(['Messages' => true]);
            // return response(['Messages' => 'Data Errors !']);
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
        ];
        $value = ['m_produk_code' => Str::lower($request->m_produk_code),];
        $validate = Validator::make($value, $rawData);
        if ($validate->fails()) {
            return response(['Messages' => 'Data Duplidate !']);
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
        return Redirect::route('m_produk.index');
        return response(['Messages' => 'Data Update !']);
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
