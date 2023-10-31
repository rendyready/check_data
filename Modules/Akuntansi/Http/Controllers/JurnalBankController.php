<?php

namespace Modules\Akuntansi\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class JurnalBankController extends Controller
{
    public function index()
    {
        $data = new \stdClass();
        $waroeng_id = Auth::user()->waroeng_id;
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama', 'm_w_id')->where('m_w_id', $waroeng_id)->first();
        $data->area_nama = DB::table('m_area')->join('m_w', 'm_w_m_area_id', 'm_area_id')->select('m_area_nama', 'm_area_id')->where('m_w_id', $waroeng_id)->first();
        $data->akses_area = $this->get_akses_area(); //mulai dari 1 - akhir
        $data->akses_pusat = $this->get_akses_pusat(); //1,2,3,4,5
        $data->akses_pusar = $this->get_akses_pusar(); //mulai dari 6 - akhir

        $data->area = DB::table('m_area')
            ->orderby('m_area_id', 'ASC')
            ->get();

        $data->waroeng = DB::table('m_w')
            ->join('m_area', 'm_area_id', 'm_w_m_area_id')
            ->select('m_w_id', 'm_w_nama', 'm_area_id', 'm_area_nama')->get();
        $data->rekening = DB::table('m_rekening')
            ->select('m_rekening_kategori', 'm_rekening_code', 'm_rekening_item')
            ->orderBy('m_rekening_code', 'asc')
            ->get();
        $data->kategori_akun = DB::table('m_rekening')
            ->select('m_rekening_kategori')
            ->orderBy('m_rekening_kategori', 'asc')
            ->groupby('m_rekening_kategori')
            ->get();

        // return $data->rekening;

        return view('akuntansi::jurnal_bank', compact('data'));
    }

    public function rekeninglink(Request $request)
    {
        $list2 = DB::table('m_rekening')
            ->select('m_rekening_code', 'm_rekening_id', 'm_rekening_nama')
            ->orderBy('m_rekening_code', 'asc')
            ->get();
        $data = array();
        foreach ($list2 as $val) {
            $data[$val->m_rekening_id] = [$val->m_rekening_nama];
        }

        return response()->json($data);
    }

    public function carijurnalnamaakun(Request $request)
    {
        $norek = DB::table('m_rekening')
            ->select('m_rekening_code')
            ->where('m_rekening_id', $request->m_rekening_nama)
            ->first();

        return response()->json($norek);
    }

    public function carijurnalnoakun(Request $request)
    {
        $norek = DB::table('m_rekening')
            ->select('m_rekening_nama', 'm_rekening_id')
            ->where('m_rekening_code', $request->m_rekening_code)
            ->first();

        return response()->json($norek);
    }

    public function tampil(Request $request)
    {
        $tanggal = $request->r_j_b_tanggal;
        $data = DB::table('rekap_jurnal_bank')
            ->select('r_j_b_id', 'r_j_b_m_rekening_code', 'r_j_b_m_rekening_nama', 'r_j_b_particul', 'r_j_b_debit', 'r_j_b_kredit', 'r_j_b_users_name', 'r_j_b_transaction_code', 'r_j_b_m_rekening_item')
            ->where('r_j_b_m_w_id', $request->r_j_b_m_w_id)
            ->where('r_j_b_status', $request->r_j_b_status)
            ->where('r_j_b_tanggal', $tanggal)
            ->orderBy('r_j_b_id', 'DESC')
            ->get();
        $output = array('data' => $data);
        return response()->json($output);
    }

    public function generatecode($prefix1, $prefix2, $prefix3)
    {
        $tanggal = date('Y-m-d', strtotime($prefix2));
        $code2 = date('Y/m/d');
        $cek_data = DB::table('rekap_jurnal_bank')
            ->join('m_w', 'm_w_id', 'r_j_b_m_w_id')
            ->select('r_j_b_transaction_code')
            ->where('r_j_b_status', $prefix1)
            ->where('r_j_b_m_w_id', $prefix3)
            ->whereDate('r_j_b_tanggal', $tanggal)
            ->orderby('r_j_b_id', 'DESC');
        $urut_pertama = '100001';
        if ($cek_data->count() == 0) {
            $code3 = $urut_pertama;
        } else {
            $toconv = $cek_data->first();
            $urut_ada = floatval(substr($toconv->r_j_b_transaction_code, 14)) + 1;
            $code3 = $urut_ada;
        }
        $buildcode = $prefix1 . '-' . $code2 . '-' . $code3;
        return $buildcode;
    }

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'r_j_b_m_rekening_code.*' => 'required',
            'r_j_b_m_rekening_nama.*' => 'required',
            'r_j_b_tanggal' => 'after:yesterday',
            'r_j_b_particul.*' => 'required',
        ]);
        // return $request->r_j_b_particul;
        if ($validator->passes()) {
            foreach ($request->r_j_b_particul as $key => $value) {
                $rekening = DB::table('m_rekening')
                    ->select('m_rekening_code', 'm_rekening_nama', 'm_rekening_id')
                    ->where('m_rekening_id', '=', $request->r_j_b_m_rekening_nama[$key])
                    ->first();
                // return $request->r_j_b_m_rekening_nama;
                [$m_w_id, $m_w_nama, $m_area_id, $m_area_nama] = explode(',', $request->input('r_j_b_m_w_id'));
                $m_w_code = sprintf("%03d", $m_w_id);
                $saldo_debit = str_replace('.', '', $request->r_j_b_debit[$key]);
                $saldo_kredit = str_replace('.', '', $request->r_j_b_kredit[$key]);
                $code = self::generatecode($request->r_j_b_status, $request->r_j_b_tanggal, $m_w_id);
                $data = array(
                    'r_j_b_id' => $this->getNextId('rekap_jurnal_bank', Auth::user()->waroeng_id),
                    'r_j_b_m_w_id' => $m_w_id,
                    'r_j_b_m_w_code' => $m_w_code,
                    'r_j_b_m_w_nama' => $m_w_nama,
                    'r_j_b_m_area_id' => $m_area_id,
                    'r_j_b_m_area_nama' => $m_area_nama,
                    'r_j_b_tanggal' => $request->r_j_b_tanggal,
                    'r_j_b_status' => $request->r_j_b_status,
                    'r_j_b_m_akun_bank_id' => 1,
                    'r_j_b_m_rekening_id' => $rekening->m_rekening_id,
                    'r_j_b_m_rekening_code' => $m_w_code . '.' . $rekening->m_rekening_code,
                    'r_j_b_m_rekening_nama' => $rekening->m_rekening_nama,
                    'r_j_b_m_rekening_item' => $request->r_j_b_m_rekening_item[$key],
                    'r_j_b_particul' => $request->r_j_b_particul[$key],
                    'r_j_b_status' => $request->r_j_b_status,
                    'r_j_b_users_name' => Auth::user()->name,
                    'r_j_b_cron_jurnal_status' => 'send',
                    'r_j_b_transaction_code' => $code,
                    'r_j_b_created_by' => Auth::user()->users_id,
                    'r_j_b_created_at' => Carbon::now(),
                );
                if ($request->r_j_b_status == 'kk') {
                    $data['r_j_b_debit'] = str_replace(',', '.', $saldo_debit);
                    $data['r_j_b_kredit'] = 0;
                } else {
                    $data['r_j_b_kredit'] = str_replace(',', '.', $saldo_kredit);
                    $data['r_j_b_debit'] = 0;
                }
                DB::table('rekap_jurnal_bank')->insert($data);
            }
            return response()->json(['messages' => 'Berhasil Menambakan', 'type' => 'success']);
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function item(Request $request)
    {
        $item = DB::table('m_rekening')
            ->select('m_rekening_nama', 'm_rekening_code', 'm_rekening_id')
            ->where('m_rekening_item', '=', $request->item_produk)
            ->orWhereRaw('m_rekening_item LIKE ?', ['%' . $request->item_produk . '%'])
            ->first();

        return response()->json($item);
    }

    public function list_item(Request $request)
    {
        $list_item = DB::table('m_rekening')
            ->select('m_rekening_code', 'm_rekening_item')
            ->orderBy('m_rekening_code', 'asc')
            ->get();
        $data = array();
        foreach ($list_item as $val) {
            $data[$val->m_rekening_item] = [$val->m_rekening_item];
        }

        return response()->json($data);
    }

}
