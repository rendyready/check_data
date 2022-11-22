<?php

namespace Modules\Master\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class WJenisController extends Controller
{
    public function index()
    {
        $data = DB::table('m_w_jenis')->whereNull('m_w_jenis_deleted_at')->get();
        return view('master::jenis_waroeng',compact('data'));
    }
    public function action(Request $request)
    { 
    	if($request->ajax())
    	{
            if ($request->action == 'add') {
                $data = array(
                    'm_w_jenis_nama'	=>	$request->m_w_jenis_nama,
                    'm_w_jenis_created_by' => Auth::id(),
                    'm_w_jenis_created_at' => Carbon::now(),
                );
                DB::table('m_w_jenis')->insert($data);
            } elseif ($request->action == 'edit') {
                $data = array(
                    'm_w_jenis_nama'	=>	$request->m_w_jenis_nama,
                    'm_w_jenis_updated_by' => Auth::id(),
                    'm_w_jenis_updated_at' => Carbon::now(),
                );
                DB::table('m_w_jenis')->where('m_w_jenis_id',$request->m_w_jenis_id)
                ->update($data);
            }else {
                $softdelete = array('m_w_jenis_deleted_at' => Carbon::now());
    			DB::table('m_w_jenis')
    				->where('m_w_jenis_id', $request->m_w_jenis_id)
    				->update($softdelete);
            }
    		return response()->json($request);
    	}
    }
}

