<?php

namespace Modules\Akuntansi\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;
class JurnalKasController extends Controller
{
    public function index()
    {

        $wrg = DB::table('m_w')->get();
        return view('akuntansi::jurnal_kas', [
            'waroeng' => $wrg,
        ]);
    }

    public function rekeninglink(Request $request)
    {
        $list2 = DB::table('m_rekening')
        ->select('m_rekening_no_akun', 'm_rekening_id', 'm_rekening_nama')
        ->orderBy('m_rekening_no_akun', 'asc')
        ->distinct('m_rekening_no_akun')
        ->get();
        $data = array();
        foreach ($list2 as $val) {
            $data[$val->m_rekening_nama] = [$val->m_rekening_nama];
        }

        return response()->json($data);
    }

    public function carijurnalnamaakun(Request $request)
    {
        
        $norek = DB::table('m_rekening')
            ->select('m_rekening_no_akun')
            ->where('m_rekening_nama', $request->m_rekening_nama)
            ->first();

        return response()->json($norek);
        
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
        $tanggal = $request->rekap_jurnal_kas_tanggal;
        $data = DB::table('rekap_jurnal_kas')
            ->select('rekap_jurnal_kas_m_rekening_no_akun', 'rekap_jurnal_kas_m_rekening_nama', 'rekap_jurnal_kas_particul', 'rekap_jurnal_kas_saldo', 'rekap_jurnal_kas_user', 'rekap_jurnal_kas_no_bukti')
            ->where('rekap_jurnal_kas_m_waroeng_id', $request->rekap_jurnal_kas_m_waroeng_id)
            ->where('rekap_jurnal_kas', $request->rekap_jurnal_kas)
            ->where('rekap_jurnal_kas_tanggal', $tanggal)
            ->orderBy('rekap_jurnal_kas_id', 'DESC')
            ->get();
        $output = array('data' => $data);
        return response()->json($output);
    }

    public function generatecode($prefix1, $prefix2, $prefix3)
    {
        $tanggal = date('Y-m-d', strtotime($prefix2));
        $code2 = date('Y/m/d');
        $cek_data = DB::table('rekap_jurnal_kas')
            ->join('m_w', 'm_w_code', 'rekap_jurnal_kas_m_waroeng_id')
            ->select('rekap_jurnal_kas_no_bukti')
            ->where('rekap_jurnal_kas', $prefix1)
            ->where('rekap_jurnal_kas_m_waroeng_id', $prefix3)
            ->whereDate('rekap_jurnal_kas_tanggal', $tanggal)
            ->orderby('rekap_jurnal_kas_id', 'DESC');
        $urut_pertama = '100001';
        if ($cek_data->count() == 0) {
            $code3 = $urut_pertama;
        } else {
            $toconv = $cek_data->first();
            $urut_ada = floatval(substr($toconv->rekap_jurnal_kas_no_bukti, 14)) + 1;
            $code3 = $urut_ada;
        }
        $buildcode = $prefix1 . '-' . $code2 . '-' . $code3;
        return $buildcode;
    }

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rekap_jurnal_kas_m_rekening_no_akun.*' => 'required',
            'rekap_jurnal_kas_m_rekening_nama.*' => 'required',
            'rekap_jurnal_kas_tanggal' => 'after:yesterday',
            'rekap_jurnal_kas_particul.*' => 'required',
            'rekap_jurnal_kas_saldo.*' => 'required',
        ]);

        if ($validator->passes()) {
            foreach ($request->rekap_jurnal_kas_particul as $key => $value) {
                $str1 = str_replace('.', '', $request->rekap_jurnal_kas_saldo[$key]);
                $code = self::generatecode($request->rekap_jurnal_kas, $request->rekap_jurnal_kas_tanggal, $request->rekap_jurnal_kas_m_waroeng_id);
                $data = array(
                    'rekap_jurnal_kas_id' => $this->getNextId('rekap_jurnal_kas', Auth::user()->waroeng_id),
                    'rekap_jurnal_kas_m_waroeng_id' => $request->rekap_jurnal_kas_m_waroeng_id,
                    'rekap_jurnal_kas_tanggal' => $request->rekap_jurnal_kas_tanggal,
                    'rekap_jurnal_kas' => $request->rekap_jurnal_kas,
                    'rekap_jurnal_kas_m_rekening_no_akun' => $request->rekap_jurnal_kas_m_rekening_no_akun[$key],
                    'rekap_jurnal_kas_m_rekening_nama' => $request->rekap_jurnal_kas_m_rekening_nama[$key],
                    'rekap_jurnal_kas_particul' => $request->rekap_jurnal_kas_particul[$key],
                    'rekap_jurnal_kas_saldo' => str_replace(',', '.', $str1),
                    'rekap_jurnal_kas_user' => Auth::user()->name,
                    'rekap_jurnal_kas_status_sync' => 'send',
                    'rekap_jurnal_kas_no_bukti' => $code,
                    'rekap_jurnal_kas_created_by' => Auth::id(),
                    'rekap_jurnal_kas_created_at' =>Carbon::now()
                );
                DB::table('rekap_jurnal_kas')->insert($data);
            }
            return response()->json(['messages' => 'Berhasil Menambakan', 'type' => 'success']);
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }
}
