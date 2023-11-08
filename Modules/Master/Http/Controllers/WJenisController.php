<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use illuminate\Support\Str;



class WJenisController extends Controller
{
    public function index()
    {
        $data = DB::table('m_w_jenis')->whereNull('m_w_jenis_deleted_at')->orderBy('m_w_jenis_id', 'asc')->get();
        return view('master::jenis_waroeng', compact('data'));
    }
    public function action(Request $request)
    {
        if ($request->ajax()) {
            $DBjenisNama = Str::lower(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $request->m_w_jenis_nama));
            $jenisNama = Str::lower(trim($DBjenisNama));
            $DBJenisWaroeng = DB::table('m_w_jenis')->selectRaw('m_w_jenis_nama')
                ->whereRaw('LOWER(m_w_jenis_nama)' . '=' . "'$jenisNama'")->first();
            if ($request->action == 'add') {
                if (!empty($DBjenisNama == null)) {
                    return response(['Messages' => 'Data Tidak Boleh Kosong !']);
                } elseif ($DBJenisWaroeng == true) {
                    return response(['Messages' => 'Data Duplicate !']);
                } else {
                    $data = array(
                        // 'm_w_jenis_id' => $this->getMasterId('m_w_jenis'),
                        'm_w_jenis_id' => '1',
                        'm_w_jenis_nama'    =>  $DBjenisNama,
                        'm_w_jenis_created_by' => Auth::user()->users_id,
                        'm_w_jenis_created_at' => Carbon::now(),
                    );
                    DB::table('m_w_jenis')->insert($data);
                    return response(['Messages' => 'Data jenis Waroeng Update !']);
                }
            } elseif ($request->action == 'edit') {
                $raw = $request->m_w_jenis_nama;
                $dataraw = Str::lower(trim($raw));
                $nameData = Str::lower(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $raw));
                $chkEdit = DB::table('m_w_jenis')
                    ->crossJoin('m_w')
                    ->selectRaw("m_w_jenis_id,LOWER(m_w_jenis_nama)")
                    // ->whereRaw("m_w_jenis.m_w_jenis_id= m_w.m_w_m_w_jenis_id")
                    ->where(DB::raw('LOWER(m_w_jenis_nama)'), $nameData)
                    ->first();
                 $nameDatap = Str::upper(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $raw));
                if (!empty($nameData == null)) {
                    return response(['Messages' => 'Data Tidak Boleh Kosong !']);
                } elseif ($chkEdit != null) {
                    return response(['Messages' => 'Data Duplicate !']);
                } elseif ($chkEdit == null) {
                    $data = array(
                        'm_w_jenis_nama' => $nameDatap,
                        'm_w_jenis_status_sync' => 'send',
                        'm_w_jenis_client_target' => DB::raw('DEFAULT'),
                        'm_w_jenis_updated_by' => Auth::user()->users_id,
                        'm_w_jenis_updated_at' => Carbon::now(),
                    );
                    DB::table('m_w_jenis')->where('m_w_jenis_id', $request->m_w_jenis_id)
                        ->update($data);
                    return response(['Messages' => 'Data update !']);
                }
            } else {
                $dataChk = $request->m_w_jenis_id;
                $delCheck =  DB::table('m_w')
                    ->select('m_w_m_w_jenis_id')->where("m_w_m_w_jenis_id", $dataChk)
                    ->first();
                if ($delCheck == null) {
                    $data = array(
                        'm_w_jenis_deleted_at' => Carbon::now(),
                        'm_w_jenis_deleted_by' => Auth::user()->users_id,
                    );

                    DB::table('m_w_jenis')
                        ->where('m_w_jenis_id', $dataChk)
                        ->update($data);
                    return response(['Messages' => 'Data Delete !']);
                } else {
                    return response(['Messages' => 'Tidak Bisa Data Delete !']);
                }
            }
        }
    }
}
