<?php

namespace Modules\Akuntansi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
class JurnalKasController extends Controller
{
    public function index()
    {

        $wrg = DB::table('m_w')->get();
        return view('akuntansi::jurnal_kas', [
            'waroeng' => $wrg,
        ]);
    }

    public function carijurnalnoakun(Request $request)
    {
        $norek = DB::table('m_rekening')
            ->select('m_rekening_nama')
            ->where('m_rekening_no_akun', $request->m_rekening_no_akun)
            ->first();

        return response()->json($norek);
    }

    public function tampil(Request $request)
    {
        $tanggal = $request->m_jurnal_kas_tanggal;
        $tanggal = date('Y-m-d', strtotime($tanggal));
        $data = DB::table('m_jurnal_kas')
            ->join('m_w', 'm_w_id', 'm_jurnal_kas_m_waroeng_id')
            ->select('m_jurnal_kas_m_rekening_no_akun', 'm_jurnal_kas_m_rekening_nama', 'm_jurnal_kas_particul', 'm_jurnal_kas_saldo', 'm_jurnal_kas_user', 'm_jurnal_kas_no_bukti')
            ->where('m_jurnal_kas_m_waroeng_id', $request->m_jurnal_kas_m_waroeng_id)
            ->where('m_jurnal_kas', $request->m_jurnal_kas_kas)
            ->whereDate('m_jurnal_kas_tanggal', $tanggal)
            ->orderBy('m_jurnal_kas_id', 'DESC')
            ->get();
        $output = array('data' => $data);
        return response()->json($output);
    }

    public function generatecode($prefix1, $prefix2, $prefix3)
    {
        $tanggal = date('Y-m-d', strtotime($prefix2));
        $code2 = date('Y/m/d');
        $cek_data = DB::table('m_jurnal_kas')
            ->join('m_w', 'm_w_id', 'm_jurnal_kas_m_waroeng_id')
            ->select('m_jurnal_kas_no_bukti')
            ->where('m_jurnal_kas', $prefix1)
            ->where('m_jurnal_kas_m_waroeng_id', $prefix3)
            ->whereDate('m_jurnal_kas_tanggal', $tanggal)
            ->orderby('m_jurnal_kas_id', 'DESC');
        $urut_pertama = '100001';
        if ($cek_data->count() == 0) {
            $code3 = $urut_pertama;
        } else {
            $toconv = $cek_data->first();
            $urut_ada = floatval(substr($toconv->m_jurnal_kas_no_bukti, 14)) + 1;
            $code3 = $urut_ada;
        }
        $buildcode = $prefix1 . '-' . $code2 . '-' . $code3;
        return $buildcode;
    }

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'm_jurnal_kas_m_rekening_no_akun.*' => 'required',
            'm_jurnal_kas_m_rekening_nama.*' => 'required',
            'm_jurnal_kas_tanggal' => 'after:yesterday',
            'm_jurnal_kas_particul.*' => 'required',
            'm_jurnal_kas_saldo.*' => 'required',
        ]);

        if ($validator->passes()) {
            foreach ($request->m_jurnal_kas_particul as $key => $value) {
                $code = self::generatecode($request->m_jurnal_kas, $request->m_jurnal_kas_tanggal, $request->m_jurnal_kas_m_waroeng_id);
                $data = array(
                    'm_jurnal_kas_m_waroeng_id' => $request->m_jurnal_kas_m_waroeng_id,
                    'm_jurnal_kas_tanggal' => $request->m_jurnal_kas_tanggal,
                    'm_jurnal_kas_kas' => $request->m_jurnal_kas,
                    'm_jurnal_kas_m_rekening_no_akun' => $request->m_jurnal_kas_m_rekening_no_akun[$key],
                    'm_jurnal_kas_m_rekening_nama' => $request->m_jurnal_kas_m_rekening_nama[$key],
                    'm_jurnal_kas_particul' => $request->m_jurnal_kas_particul[$key],
                    'm_jurnal_kas_saldo' => $request->m_jurnal_kas_saldo[$key],
                    'm_jurnal_kas_user' => Auth::user()->name,
                    'm_jurnal_kas_no_bukti' => $code,
                    'm_jurnal_kas_created_by' => Auth::id(),
                    'm_jurnal_kas_created_at' =>Carbon::now()
                );
                DB::table('m_jurnal_kas')->insert($data);
            }
            return response()->json(['message' => 'Berhasil Menambakan', 'type' => 'success']);
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }
}
