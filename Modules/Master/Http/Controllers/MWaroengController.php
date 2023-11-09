<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MW;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MWaroengController extends Controller
{
    public function index()
    {
        $data = DB::table('m_w')
            ->leftjoin('m_area', 'm_w_m_area_id', 'm_area_id')
            ->leftjoin('m_w_jenis', 'm_w_m_w_jenis_id', 'm_w_jenis_id')
            ->leftjoin('m_pajak', 'm_w_m_pajak_id', 'm_pajak_id')
            ->leftjoin('m_sc', 'm_w_m_sc_id', 'm_sc_id')
            ->leftjoin('m_modal_tipe', 'm_w_m_modal_tipe_id', 'm_modal_tipe_id')
            ->select(
                'm_w_id',
                'm_w_code',
                'm_w_nama',
                'm_area_nama',
                'm_w_jenis_nama',
                'm_w_m_kode_nota',
                'm_pajak_value',
                'm_sc_value',
                'm_modal_tipe_nama'
            )
            ->orderBy('m_w_id', 'desc')
            ->get();
        $area = DB::table('m_area')->select('m_area_id', 'm_area_nama')->get();
        $waroeng_jenis = DB::table('m_w_jenis')->select('m_w_jenis_id', 'm_w_jenis_nama')->get();
        $modaltipe = DB::table('m_modal_tipe')->select('m_modal_tipe_id', 'm_modal_tipe_nama')->get();
        $pajak = DB::table('m_pajak')->select('m_pajak_id', 'm_pajak_value')->get();
        $sc = DB::table('m_sc')->select('m_sc_id', 'm_sc_value')->get();
        $m_tipe_nota = DB::table('m_tipe_nota')->select('m_tipe_nota_nama')->get();
        return view('master::m_waroeng', compact('data', 'area', 'waroeng_jenis', 'pajak', 'sc', 'modaltipe', 'm_tipe_nota'));
    }
    public function edit($id)
    {
        $data = DB::table('m_w')->where('m_w_id', $id)->first();
        return response()->json($data);
    }
    public function action(Request $request)
    {
        // // Validatea Data
        // $MMeja = DB::table('m_meja')->select('m_meja_m_w_id')
        //     ->where('m_meja_m_w_id', 1)
        //     ->orderBy('m_meja_id', 'asc')->first();
        // $RekapBeli = DB::table('rekap_beli')->select('rekap_beli_m_w_id')
        //     ->where('rekap_beli_m_w_id', 2)->orderby('rekap_beli_id', 'asc')->first();
        // $RekapRusak = DB::table('rekap_rusak')->select('rekap_rusak_m_w_id')
        //     ->where('rekap_rusak_m_w_id', 2)->orderBy('rekap_rusak_id')->first();
        // // Validate Edit
        // $dataAdd = DB::table('m_w')->select('m_w_id')->where('m_w_id', 2)->orderBy('m_w_id', 'asc')->first();
        if ($request->ajax()) {
            if ($request->action == 'add') {
                //Validate
                $fromData = $request->m_w_nama;
                $dataLower = Str::lower(trim($fromData));
                $dbMW = DB::table('m_w')->select('m_w_nama')
                    ->where(Str::lower('m_w_nama'), preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $dataLower))
                    ->first();
                if ($dbMW == null) {
                    $countMW = DB::table('m_w')->count('m_w_id');
                    $MWcode = str_pad($countMW + 1, 3, '0', STR_PAD_LEFT);
                    $data = array(
                        // 'm_w_id' => $this->getMasterId('m_w'),
                        'm_w_id' => '1',
                        'm_w_nama' => Str::lower($request->m_w_nama),
                        'm_w_code' => $MWcode,
                        'm_w_m_area_id' => $request->m_w_m_area_id,
                        'm_w_m_w_jenis_id' => $request->m_w_m_w_jenis_id,
                        'm_w_status' => $request->m_w_status,
                        'm_w_alamat' => $request->m_w_alamat,
                        'm_w_m_kode_nota' => trim($request->m_w_m_kode_nota),
                        'm_w_m_pajak_id' => $request->m_w_m_pajak_id,
                        'm_w_m_modal_tipe_id' => $request->m_w_m_modal_tipe_id,
                        'm_w_m_sc_id' => $request->m_w_m_sc_id,
                        'm_w_decimal' => $request->m_w_decimal,
                        'm_w_pembulatan' => $request->m_w_pembulatan,
                        'm_w_currency' => $request->m_w_currency,
                        'm_w_telp' => $request->m_w_telp,
                        'm_w_created_by' => Auth::user()->users_id,
                        'm_w_created_at' => Carbon::now(),
                    );
                    DB::table('m_w')->insert($data);
                    return response(['Messages' => 'Data Tambah !']);
                }
            } else {
                $data = array(
                    'm_w_nama' => $request->m_w_nama,
                    'm_w_alamat' => $request->m_w_alamat,
                    'm_w_m_area_id' => $request->m_w_m_area_id,
                    'm_w_m_kode_nota' => $request->m_w_m_kode_nota,
                    'm_w_m_w_jenis_id' => $request->m_w_m_w_jenis_id,
                    'm_w_m_pajak_id' => $request->m_w_m_pajak_id,
                    'm_w_status' => $request->m_w_status,
                    'm_w_m_sc_id' => $request->m_w_m_sc_id,
                    'm_w_m_modal_tipe_id' => $request->m_w_m_modal_tipe_id,
                    'm_w_decimal' => $request->m_w_decimal,
                    'm_w_pembulatan' => $request->m_w_pembulatan,
                    'm_w_currency' => $request->m_w_currency,
                    'm_w_telp' => $request->m_w_telp,
                    'm_w_status_sync' => 'send',
                    'm_w_client_target' => DB::raw('DEFAULT'),
                    'm_w_updated_by' => Auth::user()->users_id,
                    'm_w_updated_at' => Carbon::now(),
                );
                DB::table('m_w')->where('m_w_id', $request->m_w_id)
                    ->update($data);
            }
            return response(['type' => 'success', 'messages' => 'Berhasil Update']);
        }
    }
    public function get_mw_akses()
    {
        $user_id = Auth::user()->users_id;
        $get_waroeng_akses = DB::table('users')->where('users_id', $user_id)->select('waroeng_akses')->first();
        $get_waroeng = DB::table('m_w')
            ->whereIn('m_w_id', json_decode($get_waroeng_akses->waroeng_akses))
            ->pluck('m_w_nama', 'm_w_id');
        return response()->json($get_waroeng);
    }

    public function update_waroeng_id($id)
    {
        DB::table('users')->where('users_id', Auth::user()->users_id)
            ->update(['waroeng_id' => $id]);
        return response()->json('success');
    }

    public function generateQRCode(Request $request)
    {
        $waroeng = MW::find($request->m_w_id);
        $waroengnama = str_replace(' ', '_', $waroeng->m_w_nama);
        $url = ($waroeng->m_area_id == 11) ? 'https://order.waroengss.com/id/en/landing' : 'https://order.waroengss.com/id/en/landing';
        $urltext = $url . '/' . $waroengnama;

        // Generate the QR code as an image
        $qrCode = QrCode::size(200)->generate($urltext);

        // Create a response with the QR code image
        $response = response($qrCode);

        return $response;
    }

}
