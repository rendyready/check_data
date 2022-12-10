<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
class JenisMejaController extends Controller
{
    public function index()
    {
        $data = DB::table('m_meja_jenis')->whereNull('m_meja_jenis_deleted_at')->get();
        return view('master::jenis_meja',compact('data'));
    }
    public function action(Request $request)
    { 
        $rules = [
            'm_meja_jenis_nama' => 'required|unique:m_meja_jenis|max:255',
            'm_meja_jenis_space' => 'required',
            'm_meja_jenis_status' => 'required'
        ];
        $data_validate = array(
            'm_meja_jenis_nama'	=>	strtolower($request->m_meja_jenis_nama),
            'm_meja_jenis_space' =>	$request->m_meja_jenis_space,
            'm_meja_jenis_status' => strtolower($request->m_meja_jenis_status),
        );
        $validator = \Validator::make($data_validate,$rules);
        if ($validator->fails()) {
            return response()->json($validator->messages()->get('*'));
        } else {
            if($request->ajax())
            {
                if ($request->action == 'add') {
                    $data = array(
                        'm_meja_jenis_nama'	=>	strtolower($request->m_meja_jenis_nama),
                        'm_meja_jenis_space' =>	$request->m_meja_jenis_space,
                        'm_meja_jenis_status' => strtolower($request->m_meja_jenis_status),
                        'm_meja_jenis_created_by' => Auth::id(),
                        'm_meja_jenis_created_at' => Carbon::now(),
                    );
                    DB::table('m_meja_jenis')->insert($data);
                } elseif ($request->action == 'edit') {
                    $data = array(
                        'm_meja_jenis_nama'	=>	strtolower($request->m_meja_jenis_nama),
                        'm_meja_jenis_space' =>	$request->m_meja_jenis_space,
                        'm_meja_jenis_status' =>	strtolower($request->m_meja_jenis_status),
                        'm_meja_jenis_updated_by' => Auth::id(),
                        'm_meja_jenis_updated_at' => Carbon::now(),
                    );
                    DB::table('m_meja_jenis')->where('m_meja_jenis_id',$request->m_meja_jenis_id)
                    ->update($data);
                }else {
                    $softdelete = array('m_meja_jenis_deleted_at' => Carbon::now());
                    DB::table('m_meja_jenis')
                        ->where('m_meja_jenis_id', $request->m_meja_jenis_id)
                        ->update($softdelete);
                }
                return response()->json(['success'=> true]);
            }
        }
    }
}
