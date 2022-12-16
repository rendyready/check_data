<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use illuminate\Support\Str;

class ProdKlasifikasiController extends Controller
{
    public function index()
    {
        $data = DB::table('m_klasifikasi_produk')->whereNull('m_klasifikasi_produk_deleted_at')->get();
        return view('master::m_klasifikasi_produk', compact('data'));
    }
    public function action(Request $request)
    {
        $raw = ['m_klasifikasi_produk_nama' => Str::lower($request->m_klasifikasi_produk_nama)];
        $value = ['m_klasifikasi_produk_nama' => ['required', 'unique:m_klasifikasi_produk', 'max:255']];
        $validate = Validator::make($raw, $value);
        if ($validate->fails()) {
            return response(['Message' => 'Data Duplicate !']);
        } else {
            if ($validate->ajax()) {
                if ($request->action == 'add') {
                    $data = array(
                        'm_klasifikasi_produk_nama'    =>   Str::lower($request->m_klasifikasi_produk_nama),
                        'm_klasifikasi_produk_created_by' => Auth::id(),
                        'm_klasifikasi_produk_created_at' => Carbon::now(),
                    );
                    DB::table('m_klasifikasi_produk')->insert($data);
                } elseif ($request->action == 'edit') {
                    $data = array(
                        'm_klasifikasi_produk_nama'    =>    $request->m_klasifikasi_produk_nama,
                        'm_klasifikasi_produk_updated_by' => Auth::id(),
                        'm_klasifikasi_produk_updated_at' => Carbon::now(),
                    );
                    DB::table('m_klasifikasi_produk')->where('m_klasifikasi_produk_id', $request->id)
                        ->update($data);
                } else {
                    $softdelete = array('m_klasifikasi_produk_deleted_at' => Carbon::now());
                    DB::table('m_klasifikasi_produk')
                        ->where('m_klasifikasi_produk_id', $request->id)
                        ->update($softdelete);
                }
                return response()->json(['Success' => $request]);
            }
        }
    }
}
