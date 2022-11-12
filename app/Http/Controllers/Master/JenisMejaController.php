<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
class JenisMejaController extends Controller
{
    public function index()
    {
        $data = DB::table('m_meja_jenis')->whereNull('m_meja_jenis_deleted_at')->get();
        return view('master.jenis_meja',compact('data'));
    }
    public function action(Request $request)
    { 
    	if($request->ajax())
    	{
            if ($request->action == 'add') {
                $data = array(
                    'm_meja_jenis_nama'	=>	$request->m_meja_jenis_nama,
                    'm_meja_jenis_space' =>	$request->m_meja_jenis_space,
                    'm_meja_jenis_status' =>	$request->m_meja_jenis_status,
                    'm_meja_jenis_created_by' => Auth::id(),
                    'm_meja_jenis_created_at' => Carbon::now(),
                );
                DB::table('m_meja_jenis')->insert($data);
            } elseif ($request->action == 'edit') {
                $data = array(
                    'm_meja_jenis_nama'	=>	$request->m_meja_jenis_nama,
                    'm_meja_jenis_space' =>	$request->m_meja_jenis_space,
                    'm_meja_jenis_status' =>	$request->m_meja_jenis_status,
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
    		return response()->json($request);
    	}
    }
}
