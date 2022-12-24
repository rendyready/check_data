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





        // $dafuk = DB::raw('Waroeng Mandiri');
        // $test = DB::table('m_area')->select('m_area_nama')
        //     ->where(DB::raw('"m_area_nama"'), '=', "$dafuk")
        //     ->get();

        // $raw = DB::table('m_w_jenis')
        //     ->crossJoin('m_w')
        //     ->selectRaw("m_w_jenis_id,m_w_jenis_nama")->whereRaw("m_w_jenis.m_w_jenis_id= m_w.m_w_m_w_jenis_id")
        //     ->where(DB::raw('m_w_jenis.m_w_jenis_nama'), '=', "$dafuk")
        //     ->get();
        // $test = Str::lower($dafuk);
        // // $has = $raw = $dafuk;
        // echo '<pre>';
        // return var_dump(['data' => $test]);
        // echo '</pre>';
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
                // return 'edit';
                $raw = $request->m_w_jenis_nama;
                $editRaw = Str::lower(trim($raw));
                $editUpdate = DB::table('m_w_jenis')->select('m_w_jenis_nama')
                    ->whereRaw('LOWER(m_w_jenis_nama)', "'$editRaw'")
                    ->orderBy('m_w_jenis_nama', 'asc')->first();
                $nameData = Str::upper(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $raw));
                if (!empty($nameData == null)) {
                    return response(['Messages' => 'Data Tidak Boleh Kosong !']);
                } elseif ($editUpdate != null) {
                    return response(['Messages' => 'Data Duplicate !']);
                } else {
                    $data = array(
                        'm_w_jenis_nama' => $nameData,
                        'm_w_jenis_updated_by' => Auth::id(),
                        'm_w_jenis_updated_at' => Carbon::now(),
                    );
                    DB::table('m_w_jenis')->where('m_w_jenis_id', $request->m_w_jenis_id)
                        ->update($data);
                    return response(['Messages' => 'Data update !']);
                }
                // return response(['Messages' => 'Data error !']);
            } else {
                $dataChk =  DB::raw('Waroeng Mandiri');
                $dataChk = Str::lower($dataChk);
                $delCheck =  DB::table('m_w_jenis')
                    ->crossJoin('m_w')
                    ->selectRaw("m_w_jenis_id,m_w_jenis_nama")->whereRaw("m_w_jenis.m_w_jenis_id= m_w.m_w_m_w_jenis_id")
                    ->where(DB::raw('m_w_jenis.m_w_jenis_nama'), '=', "$dataChk")
                    ->get();
                $delCheck = Str::lower($delCheck);
                if ($delCheck = null) {
                    $data = array(
                        'm_w_jenis_deleted_at' => Carbon::now(),
                        'm_w_jenis_deleted_by' => Auth::id(),
                    );

                    DB::table('m_w_jenis')
                        ->where('m_w_jenis_id', $request->m_w_jenis_id)
                        ->update($data);
                    return response(['Messages' => 'Data Delete !']);
                } elseif ($delCheck) {
                    return response(['Messages' => 'Tidak Bisa Data Delete !']);
                }
                return $delCheck = $delCheck->toSql();
            }
        }
    }
}
