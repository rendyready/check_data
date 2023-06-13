<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class JenisMejaController extends Controller
{
    public function index()
    {
        $data = DB::table('m_meja_jenis')->whereNull('m_meja_jenis_deleted_at')->get();
        return view('master::jenis_meja', compact('data'));
    }
    public function action(Request $request)
    {
        $m_meja_jenis_nama = trim(strtolower(preg_replace('!\s+!', ' ', $request->m_meja_jenis_nama)));
        $rules = [
            'm_meja_jenis_nama' => 'required|unique:m_meja_jenis|max:255',
            'm_meja_jenis_space' => 'required',
            'm_meja_jenis_status' => 'required'
        ];
        $data_validate = array(
            'm_meja_jenis_nama' =>  trim(strtolower(preg_replace('!\s+!', ' ', $request->m_meja_jenis_nama))),
            'm_meja_jenis_space' =>    $request->m_meja_jenis_space,
            'm_meja_jenis_status' => $request->m_meja_jenis_status,
        );
        $validator = Validator::make($data_validate, $rules, $messages = [
            'm_meja_jenis_nama.required' => 'Nama Jenis Meja Belum Terisi',
            'm_meja_jenis_nama.unique' => 'Nama Jenis Meja Duplikat',
            'm_meja_jenis_space.required' => 'Kapasitas Meja Belum Terisi',
            'm_meja_jenis_status.required' => 'Status Jenis Meja Belum Terisi'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->messages()->all(),'type'=>'danger']);
        } else {
            if ($request->ajax()) {
                if ($request->action == 'add') {
                    $data = array(
                        'm_meja_jenis_id' => $this->getMasterId('m_meja_jenis'),
                        'm_meja_jenis_nama'  =>  $m_meja_jenis_nama,
                        'm_meja_jenis_space' =>  $request->m_meja_jenis_space,
                        'm_meja_jenis_status' => strtolower($request->m_meja_jenis_status),
                        'm_meja_jenis_created_by' => Auth::user()->users_id,
                        'm_meja_jenis_created_at' => Carbon::now(),
                    );
                    DB::table('m_meja_jenis')->insert($data);
                } elseif ($request->action == 'edit') {
                    $data = array(
                        'm_meja_jenis_nama'    =>    strtolower($request->m_meja_jenis_nama),
                        'm_meja_jenis_space' =>    $request->m_meja_jenis_space,
                        'm_meja_jenis_status' =>    strtolower($request->m_meja_jenis_status),
                        'm_meja_jenis_status_sync' => 'send',
                        'm_meja_jenis_updated_by' => Auth::user()->users_id,
                        'm_meja_jenis_updated_at' => Carbon::now(),
                    );
                    DB::table('m_meja_jenis')->where('m_meja_jenis_id', $request->m_meja_jenis_id)
                        ->update($data);
                } else {
                    $softdelete = array('m_meja_jenis_deleted_at' => Carbon::now());
                    DB::table('m_meja_jenis')
                        ->where('m_meja_jenis_id', $request->m_meja_jenis_id)
                        ->update($softdelete);
                }
                return response()->json(['error'=>['Berhasil'],'type'=>'success']);
            }
        }
    }
}
