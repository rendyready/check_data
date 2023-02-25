<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use illuminate\Support\Str;
use illuminate\Support\Facades\Validator;

class MejaController extends Controller
{
    public function index()
    {
        $data = new \stdClass();
        $data->no = 1;
        $data->meja = DB::table('m_meja')
            ->leftjoin('m_meja_jenis', 'm_meja_m_meja_jenis_id', 'm_meja_jenis_id')
            ->leftjoin('m_w', 'm_w_id', 'm_meja_m_w_id')->get();
        $data->jenis_meja = DB::table('m_meja_jenis')->get();
        $data->waroeng = DB::table('m_w')->get();
        return view('master::m_meja', compact('data'));
    }
    public function list($id)
    {
        $data = DB::table('m_meja')->where('m_meja_id', $id)->first();
        return response()->json($data, 200);
    }
    public function simpan(Request $request)
    {
        for ($i = $request->mulai_meja; $i <= $request->selesai_meja; $i++) {
            if ($request->m_meja_type == 'meja') {
                $nama = str_pad($i, 2, '0', STR_PAD_LEFT);
            } elseif ($request->m_meja_type == 'bungkus') {
                $nama = 'Bks '.str_pad($i, 2, '0', STR_PAD_LEFT);
            } else {
                $nama = 'Express '.str_pad($i, 2, '0', STR_PAD_LEFT);
            }
            
            $data = DB::table('m_meja')->insert([
                "m_meja_id" => $this->getMasterId('m_meja'),
                "m_meja_nama" => $nama,
                "m_meja_m_meja_jenis_id" => $request->jenis_meja,
                "m_meja_m_w_id" => $request->waroeng,
                "m_meja_type" => $request->m_meja_type,
                "m_meja_created_by" => Auth::id(),
                "m_meja_created_at" => Carbon::now(),
            ]);
        }
        return Redirect::route('meja.index');
    }
    public function edit(Request $request)
    {
        DB::table('m_meja')->where('m_meja_id', $request->id_meja)
            ->update([
                "m_meja_nama" => $request->nama_meja,
                "m_meja_m_meja_jenis_id" => $request->jenis_meja,
                "m_meja_m_w_id" => $request->waroeng,
                "m_meja_updated_by" => Auth::id(),
                "m_meja_updated_at" => Carbon::now(),
            ]);
        return Redirect::route('meja.index');
    }
    public function hapus($id)
    {
        $data = DB::table('m_meja')->where('m_meja_id', '=', $id)->delete();
        return Redirect::route('meja.index');
    }
}
