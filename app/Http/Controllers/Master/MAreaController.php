<?php

namespace App\Http\Controllers\Master;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MArea;
use Carbon\Carbon;
class MAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $data = MArea::select('id','m_area_nama')->whereNull('m_area_deleted_at')->orderBy('id','asc')->get();
        return view('master.area',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    function action(Request $request)
    {
    	if($request->ajax())
    	{
    		if($request->action == 'edit')
    		{
    			$data = array(
    				'm_area_nama'	=>	$request->m_area_nama,
                    'm_area_updated_by' => Auth::id(),
                    'm_area_updated_at' => Carbon::now(),
    			);
    			DB::table('m_area')
    				->where('id', $request->id)
    				->update($data);
    		}
    		if($request->action == 'delete')
    		{
                $softdelete = array('m_area_deleted_at' => Carbon::now());
    			DB::table('m_area')
    				->where('id', $request->id)
    				->update($softdelete);
    		}
    		return response()->json($request);
    	}
    }
}