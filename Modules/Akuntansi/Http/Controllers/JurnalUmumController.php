<?php

namespace Modules\Akuntansi\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
        $tanggal = $request->m_jurnal_umum_tanggal;
        $tanggal = date('Y-m-d', strtotime($tanggal));
        $data = DB::table('m_jurnal_umum')
            ->join('m_w', 'm_w_id', 'm_jurnal_umum_m_waroeng_id')
            ->select('m_jurnal_umum_m_rekening_no_akun', 'm_jurnal_umum_m_rekening_nama', 'm_jurnal_umum_particul', 'm_jurnal_umum_debit', 'm_jurnal_umum_kredit', 'm_jurnal_umum_user', 'm_jurnal_umum_no_bukti')
            ->where('m_jurnal_umum_m_waroeng_id', $request->m_jurnal_umum_m_waroeng_id)
            ->whereDate('m_jurnal_umum_tanggal', $tanggal)
            ->orderBy('m_jurnal_umum_id', 'DESC')
            ->get();
        $output = array('data' => $data);
        return response()->json($output);

    }

    public function generatecode($prefix1, $prefix2)
    {
        $tanggal = date('Y-m-d', strtotime($prefix1));
        $code2 = date('Y/m/d');
        $cek_data = DB::table('m_jurnal_umum')
            ->join('m_w', 'm_w_id', 'm_jurnal_umum_m_waroeng_id')
            ->select('m_jurnal_umum_no_bukti')
            ->where('m_jurnal_umum_m_waroeng_id', $prefix2)
            ->whereDate('m_jurnal_umum_tanggal', $tanggal)
            ->orderby('m_jurnal_umum_id', 'DESC');

        if ($cek_data->count() == 0) {
            $code3 = '100001';
        } else {
            $toconv = $cek_data->first();
            $code3 = floatval(substr($toconv->m_jurnal_umum_no_bukti, 11)) + 1;
        }
        $buildcode = $code2 . '-' . $code3;
        return $buildcode;
    }

    public function simpan(Request $request)
    {
        $debit = $request->m_jurnal_umum_debit;
        $kredit = $request->m_jurnal_umum_kredit;
        $validator = Validator::make($request->all(), [
            'm_jurnal_umum_m_rekening_no_akun.*' => 'required',
            'm_jurnal_umum_m_rekening_nama.*' => 'required',
            'm_jurnal_umum_tanggal' => 'after:yesterday',
            'm_jurnal_umum_particul.*' => 'required',
            'm_jurnal_umum_debit.*' => 'required',
            'm_jurnal_umum_kredit.*' => 'required',
        ]);

        if ($validator->passes()) {
            foreach ($request->m_jurnal_umum_particul as $key => $value) {
                $code = self::generatecode($request->m_jurnal_umum_tanggal, $request->m_jurnal_umum_m_waroeng_id);
                $data = array(
                    'm_jurnal_umum_m_waroeng_id' => $request->m_jurnal_umum_m_waroeng_id,
                    'm_jurnal_umum_tanggal' => $request->m_jurnal_umum_tanggal,
                    'm_jurnal_umum_m_rekening_no_akun' => $request->m_jurnal_umum_m_rekening_no_akun[$key],
                    'm_jurnal_umum_m_rekening_nama' => $request->m_jurnal_umum_m_rekening_nama[$key],
                    'm_jurnal_umum_particul' => $request->m_jurnal_umum_particul[$key],
                    'm_jurnal_umum_debit' => $request->m_jurnal_umum_debit[$key],
                    'm_jurnal_umum_kredit' => $request->m_jurnal_umum_kredit[$key],
                    'm_jurnal_umum_user' => Auth::user()->name,
                    'm_jurnal_umum_no_bukti' => $code,
                    'm_jurnal_umum_created_by' => Auth::id,
                    'm_jurnal_umum_created_at' => Carbon::now()
                );
                DB::table('m_jurnal_umum')->insert($data);
            }
            return response()->json(['messages' => 'Berhasil Menambakan', 'type' => 'success']);
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }
}
