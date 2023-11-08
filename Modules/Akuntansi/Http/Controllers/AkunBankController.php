<?php

namespace Modules\Akuntansi\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use illuminate\Support\Str;

class AkunBankController extends Controller
{

    public function index()
    {
        $data = DB::table('m_akun_bank')->select('m_akun_bank_id', 'm_akun_bank_name', 'm_akun_bank_m_rekening_id')->orderby('m_akun_bank_id', 'asc')->get();

        return view('akuntansi::akun_bank', compact('data'));
    }

    public function action(Request $request)
    {
        if ($request->ajax()) {
            if ($request->action == 'add') {
                $nama_akun = Str::lower(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $request->m_akun_bank_name));
                $nama_akun = str::lower(trim($aa));
                $id_rekening = $request->m_akun_bank_m_rekening_id;
                $nama_waroeng = $request->m_akun_bank_m_rekening_id;

                $tb = DB::table('m_akun_bank')
                    ->selectRaw('m_akun_bank_name, m_akun_bank_m_rekening_id')
                    ->whereRaw('LOWER(m_akun_bank_name) =' . "'$nama_akun'")
                    ->whereRaw('m_akun_bank_m_rekening_id =' . "'$id_rekening'")
                    ->first();

                // Count
                $count = '1';
                $DB = DB::table('m_akun_bank')->get()->count('m_akun_bank_id');
                if ($DB == 0) {
                    $DBCount = $count;
                } else {
                    $DBCount = $DB + 1;
                }

                if ($nama_akun == null) {
                    return response(['Messages' => 'Data Tidak Boleh Kosong !', 'type' => 'danger']);
                } elseif (!empty($tb)) {
                    // return response($this);
                    return response(['Messages' => 'Data Duplikat !', 'type' => 'danger']);
                } else {
                    if ($tb == null) {
                        DB::table('m_area')->insert([
                            'm_akun_bank_id' => $this->getMasterId('m_akun_bank_id'),
                            'm_akun_bank_m_w_id' => $request->m_akun_bank_m_w_id,
                            'm_area_nama' => Str::lower(trim($request->m_area_nama)),
                            'm_area_code' => $DBCount,
                            'm_area_created_by' => Auth::user()->users_id,
                            'm_area_created_at' => Carbon::now(),
                        ]);
                        return response(['Messages' => 'Berhasil Tambah Area !', 'type' => 'success']);
                    } else {
                        return response(['Messages' => 'Data Duplikat !', 'type' => 'danger']);
                    }
                }
            } elseif ($request->action == 'edit') {
                $ii = Str::lower($request->m_akun_bank_name);
                $trim = trim(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $ii));
                $ss = $request->m_akun_bank_m_rekening_id;
                $validate = DB::table('m_akun_bank')->selectRaw('m_akun_bank_name, m_akun_bank_m_rekening_id')->whereRaw(' LOWER(m_akun_bank_name) =' . "'$trim'")->whereRaw('m_akun_bank_m_rekening_id =' . "'$ss'")->get();
                $data = array(
                    'm_akun_bank_name' => Str::lower($trim),
                    'm_akun_bank_m_rekening_id' => $ss,
                    'm_akun_bank_client_target' => DB::raw('DEFAULT'),
                    'm_akun_bank_updated_by' => Auth::user()->users_id,
                    'm_akun_bank_updated_at' => Carbon::now(),
                );
                if (!empty($validate)) {
                    DB::table('m_akun_bank')->where('m_akun_bank_id', $request->id)
                        ->update($data);
                    return response(['Messages' => 'Data Update !', 'type' => 'success']);
                } else {
                    return response(['Messages' => 'Data Gagal Update !', 'type' => 'danger']);
                }
            } else {
                $dataRaws = $request->id;
                $RawDelete = DB::table('m_w')->selectRaw('m_w_m_area_id')
                    ->where('m_w_m_area_id', $dataRaws)
                    ->whereNull('m_w_deleted_at')->first();
                if ($RawDelete == null) {
                    $data = array(
                        'm_area_deleted_at' => Carbon::now(),
                        'm_area_deleted_by' => Auth::user()->users_id,
                    );
                    DB::table('m_area')
                        ->where('m_area_id', $request->id)
                        ->update($data);
                    return response(['Messages' => 'Data Terhapus !']);
                } elseif ($RawDelete == $RawDelete) {
                    return response(['Messages' => 'Data Ada Tidak Bisa Hapus !']);
                }
            }
        }
    }
}
