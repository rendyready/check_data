<?php

namespace Modules\Akuntansi\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class RekeningController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $wrg = DB::table('m_w')
            ->orderby('m_w_id', 'ASC')
            ->get();
        return view('akuntansi::rekening', ['waroeng' => $wrg]);
    }

    public function tampil(Request $request)
    {
        $data = DB::table('m_rekening')
            ->join('m_w', 'm_w_id', 'm_rekening_m_waroeng_id')
            ->select('m_rekening_kategori', 'm_rekening_no_akun', 'm_rekening_nama', 'm_rekening_saldo')
            ->where('m_rekening_kategori', $request->m_rekening_kategori)
            ->where('m_rekening_m_waroeng_id', $request->m_rekening_m_waroeng_id)
            ->orderBy('m_rekening_id', 'DESC')
            ->get();
        $output = array('data' => $data);
        return response()->json($output);
    }
    public function validasinama(Request $request)
    {
        $val = $request->m_rekening_nama;
        $validasi = DB::table('m_rekening')
            ->where('m_rekening_nama', $val)
            ->count();
        return response()->json($validasi);

    }
    public function validasino(Request $request)
    {
        $val = $request->m_rekening_no_akun;
        $validasi = DB::table('m_rekening')
            ->where('m_rekening_no_akun', $val)
            ->count();
        return response()->json($validasi);

    }

    public function simpan(Request $request)
    {
        foreach ($request->m_rekening_no_akun as $key => $value) {
            $data = array(
                'm_rekening_m_waroeng_id' => $request->m_rekening_m_waroeng_id,
                'm_rekening_kategori' => $request->m_rekening_kategori,
                'm_rekening_no_akun' => $request->m_rekening_no_akun[$key],
                'm_rekening_nama' => strtolower($request->m_rekening_nama[$key]),
                'm_rekening_saldo' => $request->m_rekening_saldo[$key],
                'm_rekening_created_by' => Auth::id(),
                'm_rekening_created_at' => Carbon::now()

            );
            DB::table('m_rekening')->insert($data);
        }
        return response()->json(['messages' => 'Berhasil Menambakan', 'type' => 'success']);

    }

    public function copyrecord(Request $request)
    {
        $get_data = DB::table('m_rekening')
            ->where('m_rekening_m_waroeng_id', $request->waroeng_asal)
            ->get();
        foreach ($get_data as $key) {
            $get_data2 = DB::table('m_rekening')
                ->where('m_rekening_m_waroeng_id', $request->waroeng_tujuan)
                ->where('m_rekening_kategori', $key->m_rekening_kategori)
                ->where('m_rekening_no_akun', $key->m_rekening_no_akun)
                ->where('m_rekening_nama', $key->m_rekening_nama)
                ->first();
            if (empty($get_data2)) {
                $saldo = ($request->m_rekening_saldo_copy == 'tidak') ? 0 : $key->m_rekening_saldo ;
                $data = array(
                    'm_rekening_m_waroeng_id' => $request->waroeng_tujuan,
                    'm_rekening_kategori' => $key->m_rekening_kategori,
                    'm_rekening_no_akun' => $key->m_rekening_no_akun,
                    'm_rekening_nama' => $key->m_rekening_nama,
                    'm_rekening_saldo' => $saldo,
                    'm_rekening_created_by' => Auth::id(),
                    'm_rekening_created_at' => Carbon::now()
                );
                DB::table('m_rekening')->insert($data);
            }
        }
        return response()->json(['messages' => 'Berhasil copy ke waroeng lain', 'type' => 'success']);
    }

}
