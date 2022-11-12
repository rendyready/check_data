<?php

namespace App\Http\Controllers\Master;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class SubJenisMController extends Controller
{
    public function index()
    {
        $data = new \stdClass();
        $data->sub = DB::table('m_sub_menu_jenis as msj')
        ->leftjoin('m_menu_jenis as mmj', 'msj.m_sub_menu_jenis_m_menu_jenis_id', '=', 'mmj.id')
        ->select('msj.id','msj.m_sub_menu_jenis_nama','mmj.m_menu_jenis_nama')
        ->whereNull('msj.m_sub_menu_jenis_deleted_at')->get();
        $data->test = DB::table('m_menu_jenis')->select('id','m_menu_jenis_nama')->get();
        return view('master.sub_jenis_menu',compact('data'));
    }
    public function action(Request $request)
    { 
    	if($request->ajax())
    	{
            if ($request->action == 'add') {
                $data = array(
                    'm_sub_menu_jenis_nama'	=>	$request->m_sub_menu_jenis_nama,
                    'm_sub_menu_jenis_m_menu_jenis_id' => $request->m_sub_menu_jenis_m_menu_jenis_id,
                    'm_sub_menu_jenis_created_by' => Auth::id(),
                    'm_sub_menu_jenis_created_at' => Carbon::now(),
                );
                DB::table('m_sub_menu_jenis')->insert($data);
            } elseif ($request->action == 'edit') {
                $data = array(
                    'm_sub_menu_jenis_nama'	=>	$request->m_sub_menu_jenis_nama,
                    'm_sub_menu_jenis_m_menu_jenis_id' => $request->m_sub_menu_jenis_m_menu_jenis_id,
                    'm_sub_menu_jenis_updated_by' => Auth::id(),
                    'm_sub_menu_jenis_updated_at' => Carbon::now(),
                );
                DB::table('m_sub_menu_jenis')->where('id',$request->id)
                ->update($data);
            }else {
                $softdelete = array('m_sub_menu_jenis_deleted_at' => Carbon::now());
    			DB::table('m_sub_menu_jenis')
    				->where('id', $request->id)
    				->update($softdelete);
            }
    		return response()->json($request);
    	}
    }

}
