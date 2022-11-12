<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class SCController extends Controller
{
    public function index()
    {
        $data = DB::table('m_sc')->whereNull('m_sc_deleted_at')->get();
        return view('master.sc',compact('data'));
    }
    public function action(Request $request)
    { 
    	if($request->ajax())
    	{
            if ($request->action == 'add') {
                $data = array(
                    'm_sc_value'	=>	$request->m_sc_value,
                    'm_sc_created_by' => Auth::id(),
                    'm_sc_created_at' => Carbon::now(),
                );
                DB::table('m_sc')->insert($data);
            } elseif ($request->action == 'edit') {
                $data = array(
                    'm_sc_value'	=>	$request->m_sc_value,
                    'm_sc_updated_by' => Auth::id(),
                    'm_sc_updated_at' => Carbon::now(),
                );
                DB::table('m_sc')->where('id',$request->id)
                ->update($data);
            }else {
                $softdelete = array('m_sc_jenis_deleted_at' => Carbon::now());
    			DB::table('m_sc')
    				->where('id', $request->id)
    				->update($softdelete);
            }
    		return response()->json($request);
    	}
    }

}
