<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Middleware\TrustHosts;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use illuminate\Support\Str;



class WJenisController extends Controller
{
    public function index()
    {
        $data = DB::table('m_w_jenis')->whereNull('m_w_jenis_deleted_at')->get();
        return view('master::jenis_waroeng', compact('data'));


        // $destroy = DB::table('m_w_jenis')->select('m_w_jenis_id', 'm_w_jenis_nama')
        //     ->where('m_w_jenis_id', 2)
        //     ->first();
        // $delCheck = DB::table('m_w')->selectRaw('m_w_m_w_jenis_id')
        //     ->where('m_w_m_w_jenis_id', $destroy)->first();
        // if ($delCheck == null) {
        //     return response(['Messages' => 'Data asa Delete !']);
        // } elseif ($delCheck == $delCheck) {
        //     return response(['Messages' => 'Tidak Bisa Data Delete !']);
        // }
        // return $destroy;
    }
    public function action(Request $request)
    {
        if ($request->ajax()) {
            $DBjenisNama = Str::upper(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $request->m_w_jenis_nama));
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
                        'm_w_jenis_nama'    =>  $DBjenisNama,
                        'm_w_jenis_created_by' => Auth::id(),
                        'm_w_jenis_created_at' => Carbon::now(),
                    );
                    DB::table('m_w_jenis')->insert($data);
                    return response(['Messages' => 'Data jenis Waroeng Update !']);
                }
            } elseif ($request->action == 'edit') {
                $raw = Str::upper(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $request->m_w_jenis_nama));
                $editRaw = Str::lower(trim($raw));
                $editUpdate = DB::table('m_w_jenis')->selectRaw('m_w_jenis_nama')->whereRaw('LOWER(m_w_jenis_nama)' . "'$editRaw'")->orderBy('m_w_jenis_nama', 'asc');
                if (!empty($raw == null)) {
                    return response(['Messages' => 'Data Tidak Boleh Kosong !']);
                } elseif ($editUpdate == $editUpdate) {
                    return response(['Messages' => 'Data Duplicate !']);
                } else {
                    $data = array(
                        'm_w_jenis_nama' => $raw,
                        'm_w_jenis_updated_by' => Auth::id(),
                        'm_w_jenis_updated_at' => Carbon::now(),
                    );
                    DB::table('m_w_jenis')->where('m_w_jenis_id', $request->m_w_jenis_id)
                        ->update($data);
                    return response(['Messages' => 'Data update !']);
                }
                return response(['Messages' => 'Data error !']);
            } else {
                $destroy = $request->id;
                $delCheck = DB::table('m_w')->select('m_w_m_w_jenis_id')
                    ->where('m_w_m_w_jenis_id', $destroy)
                    ->whereNull('m_w_deleted_at')->first();
                if ($delCheck == null) {
                    $data = array(
                        'm_w_jenis_deleted_at' => Carbon::now(),
                        'm_w_jenis_deleted_by' => Auth::id(),
                    );
                    DB::table('m_w_jenis')
                        ->where('m_w_jenis_id', $destroy)
                        ->update($data);
                    return response(['Messages' => 'Data Delete !']);
                } elseif ($delCheck == true) {
                    return response(['Messages' => 'Tidak Bisa Data Delete !']);
                }
                // $softdelete = array('m_w_jenis_deleted_at' => Carbon::now());
                // DB::table('m_w_jenis')
                //     ->where('m_w_jenis_id', $request->m_w_jenis_id)
                //     ->update($softdelete);
                // return response(['Messages' => 'Data Delete !']);
            }
        }
    }
}
