<?php

namespace Modules\Akuntansi\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Validator;
class JurnalUmumController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $wrg = DB::table('m_w')->get();
        return view('akuntansi::jurnal_umum', [
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
        $tanggal = $request->rekap_jurnal_umum_tanggal;
        $data = DB::table('rekap_jurnal_umum')
            ->select('rekap_jurnal_umum_m_rekening_no_akun', 'rekap_jurnal_umum_m_rekening_nama', 'rekap_jurnal_umum_particul', 'rekap_jurnal_umum_debit', 'rekap_jurnal_umum_kredit', 'rekap_jurnal_umum_user', 'rekap_jurnal_umum_no_bukti')
            ->where('rekap_jurnal_umum_m_waroeng_id', $request->rekap_jurnal_umum_m_waroeng_id)
            ->whereDate('rekap_jurnal_umum_tanggal', $tanggal)
            ->orderBy('rekap_jurnal_umum_id', 'DESC')
            ->get();
        $output = array('data' => $data);
        return response()->json($output);

    }

    public function generatecode($prefix1, $prefix2)
    {
        $tanggal = date('Y-m-d', strtotime($prefix1));
        $code2 = date('Y/m/d');
        $cek_data = DB::table('rekap_jurnal_umum')
            ->join('m_w', 'm_w_code', 'rekap_jurnal_umum_m_waroeng_id')
            ->select('rekap_jurnal_umum_no_bukti')
            ->where('rekap_jurnal_umum_m_waroeng_id', $prefix2)
            ->whereDate('rekap_jurnal_umum_tanggal', $tanggal)
            ->orderby('rekap_jurnal_umum_id', 'DESC');

        if ($cek_data->count() == 0) {
            $code3 = '100001';
        } else {
            $toconv = $cek_data->first();
            $code3 = floatval(substr($toconv->rekap_jurnal_umum_no_bukti, 11)) + 1;
        }
        $buildcode = $code2 . '-' . $code3;
        return $buildcode;
    }

    public function simpan(Request $request)
    {
        $debit = $request->rekap_jurnal_umum_debit;
        $kredit = $request->rekap_jurnal_umum_kredit;
        $validator = Validator::make($request->all(), [
            'rekap_jurnal_umum_m_rekening_no_akun.*' => 'required',
            'rekap_jurnal_umum_m_rekening_nama.*' => 'required',
            'rekap_jurnal_umum_tanggal' => 'after:yesterday',
            'rekap_jurnal_umum_particul.*' => 'required',
            'rekap_jurnal_umum_debit.*' => 'required',
            'rekap_jurnal_umum_kredit.*' => 'required',
        ]);

        if ($validator->passes()) {
            foreach ($request->rekap_jurnal_umum_particul as $key => $value) {
                $str1 = str_replace('.', '', $request->rekap_jurnal_umum_debit[$key]);
                $str2 = str_replace('.', '', $request->rekap_jurnal_umum_kredit[$key]);
                $code = self::generatecode($request->rekap_jurnal_umum_tanggal, $request->rekap_jurnal_umum_m_waroeng_id);
                $data = array(
                    'rekap_jurnal_umum_id' => $this->getNextId('rekap_jurnal_umum', Auth::user()->waroeng_id),
                    'rekap_jurnal_umum_m_waroeng_id' => $request->rekap_jurnal_umum_m_waroeng_id,
                    'rekap_jurnal_umum_tanggal' => $request->rekap_jurnal_umum_tanggal,
                    'rekap_jurnal_umum_m_rekening_no_akun' => $request->rekap_jurnal_umum_m_rekening_no_akun[$key],
                    'rekap_jurnal_umum_m_rekening_nama' => $request->rekap_jurnal_umum_m_rekening_nama[$key],
                    'rekap_jurnal_umum_particul' => $request->rekap_jurnal_umum_particul[$key],
                    'rekap_jurnal_umum_debit' => str_replace(',', '.', $str1),
                    'rekap_jurnal_umum_kredit' => str_replace(',', '.', $str2),
                    'rekap_jurnal_umum_user' => Auth::user()->name,
                    'rekap_jurnal_umum_status_sync' => 'send',
                    'rekap_jurnal_umum_no_bukti' => $code,
                    'rekap_jurnal_umum_created_by' => Auth::id(),
                    'rekap_jurnal_umum_created_at' => Carbon::now()
                );
                DB::table('rekap_jurnal_umum')->insert($data);
            }
            return response()->json(['messages' => 'Berhasil Menambakan', 'type' => 'success']);
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }
}
