<?php

namespace Modules\Akuntansi\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class JurnalBankController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $wrg = DB::table('m_w')->get();
        return view('akuntansi::jurnal_bank', [
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
        // return $request;
        $tanggal = $request->rekap_jurnal_bank_tanggal;
        $data = DB::table('rekap_jurnal_bank')
            ->select('rekap_jurnal_bank_m_rekening_no_akun', 'rekap_jurnal_bank_m_rekening_nama', 'rekap_jurnal_bank_particul', 'rekap_jurnal_bank_saldo', 'rekap_jurnal_bank_user', 'rekap_jurnal_bank_no_bukti')
            ->where('rekap_jurnal_bank_m_waroeng_id', $request->rekap_jurnal_bank_m_waroeng_id)
            ->where('rekap_jurnal_bank_kas', $request->rekap_jurnal_bank_kas)
            ->whereDate('rekap_jurnal_bank_tanggal', $tanggal)
            ->orderBy('rekap_jurnal_bank_id', 'DESC')
            ->get();
        $output = array('data' => $data);
        return response()->json($output);

    }

    public function generatecode($prefix1, $prefix2, $prefix3)
    {
        $tanggal = date('Y-m-d', strtotime($prefix2));
        $code2 = date('Y/m/d');
        $cek_data = DB::table('rekap_jurnal_bank')
            ->join('m_w', 'm_w_code', 'rekap_jurnal_bank_m_waroeng_id')
            ->select('rekap_jurnal_bank_no_bukti')
            ->where('rekap_jurnal_bank_kas', $prefix1)
            ->where('rekap_jurnal_bank_m_waroeng_id', $prefix3)
            ->whereDate('rekap_jurnal_bank_tanggal', $tanggal)
            ->orderby('rekap_jurnal_bank_id', 'DESC');

        $urut_pertama = '100001';
        if ($cek_data->count() == 0) {
            $code3 = $urut_pertama;
        } else {
            $toconv = $cek_data->first();
            $urut_ada = floatval(substr($toconv->rekap_jurnal_bank_no_bukti, 14)) + 1;
            $code3 = $urut_ada;
        }
        $buildcode = $prefix1 . '-' . $code2 . '-' . $code3;
        return $buildcode;
    }

    public function simpan(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'rekap_jurnal_bank_m_rekening_no_akun.*' => 'required',
            'rekap_jurnal_bank_m_rekening_nama.*' => 'required',
            'rekap_jurnal_bank_tanggal' => 'after:yesterday',
            'rekap_jurnal_bank_particul.*' => 'required',
            'rekap_jurnal_bank_saldo.*' => 'required',
        ]);

        if ($validator->passes()) {
            foreach ($request->rekap_jurnal_bank_particul as $key => $value) {
                $str1 = str_replace('.', '', $request->rekap_jurnal_bank_saldo[$key]);
                $code = self::generatecode($request->rekap_jurnal_bank_kas, $request->rekap_jurnal_bank_tanggal, $request->rekap_jurnal_bank_m_waroeng_id);
                $data = array(
                    'rekap_jurnal_bank_id' => $this->getNextId('rekap_jurnal_bank', Auth::user()->waroeng_id),
                    'rekap_jurnal_bank_m_waroeng_id' => $request->rekap_jurnal_bank_m_waroeng_id,
                    'rekap_jurnal_bank_tanggal' => $request->rekap_jurnal_bank_tanggal,
                    'rekap_jurnal_bank_kas' => $request->rekap_jurnal_bank_kas,
                    'rekap_jurnal_bank_m_rekening_no_akun' => $request->rekap_jurnal_bank_m_rekening_no_akun[$key],
                    'rekap_jurnal_bank_m_rekening_nama' => $request->rekap_jurnal_bank_m_rekening_nama[$key],
                    'rekap_jurnal_bank_particul' => $request->rekap_jurnal_bank_particul[$key],
                    'rekap_jurnal_bank_saldo' => str_replace(',', '.', $str1),
                    'rekap_jurnal_bank_user' => Auth::user()->name,
                    'rekap_jurnal_bank_status_sync' => 'send',
                    'rekap_jurnal_bank_no_bukti' => $code,
                    'rekap_jurnal_bank_created_by' => Auth::user()->users_id,
                    'rekap_jurnal_bank_created_at' => Carbon::now(),
                );

                DB::table('rekap_jurnal_bank')->insert($data);
            }

            return response()->json(['messages' => 'Berhasil Menambakan', 'type' => 'success']);
        }

        return response()->json(['error' => $validator->errors()->all()]);

    }

}
