<?php

namespace App\Http\Controllers\Master;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MMenuJeni;
use Carbon\Carbon;

class MJenisMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MMenuJeni::select('id','m_menu_jenis_nama','m_menu_jenis_odcr55','m_menu_jenis_urut')->whereNull('m_menu_jenis_deleted_at')->orderBy('id','asc')->get();
        return view('master.jenis_menu',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function action(Request $request)
    { 
        // $validator = \Validator::make($request->all(), [
        //     'm_area_nama' => 'required',
        // ]);
        $count = MMenuJeni::max('id');
    	if($request->ajax())
    	{
            if ($request->action == 'add') {
                $data = array(
                    'm_menu_jenis_nama' => $request->m_menu_jenis_nama, 
                    'm_menu_jenis_odcr55' =>$request->m_menu_jenis_odcr55,
                    'm_menu_jenis_urut' => $count + 1,
                    'm_menu_jenis_created_by' => Auth::id(),
                    'm_menu_jenis_created_at' => Carbon::now(),
                );
                DB::table('m_menu_jenis')->insert($data);
            } elseif ($request->action == 'edit') {
                $data = array(
                    'm_menu_jenis_nama' => $request->m_menu_jenis_nama, 
                    'm_menu_jenis_odcr55' =>$request->m_menu_jenis_odcr55,
                    'm_menu_jenis_updated_by' => Auth::id(),
                    'm_menu_jenis_updated_at' => Carbon::now(),
                );
                DB::table('m_menu_jenis')->where('id',$request->id)
                ->update($data);
            } else {
                $softdelete = array('m_menu_jenis_deleted_at' => Carbon::now());
    			DB::table('m_menu_jenis')
    				->where('id', $request->id)
    				->update($softdelete);
            }
    		return response()->json($request);
    	}
    }
    public function sort(Request $request)
    {
        $tasks = MMenuJeni::all();

        foreach ($tasks as $task) {
            $task->timestamps = false; // To disable update_at field updation
            $id = $task->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $task->update(['m_menu_jenis_urut' => $order['position']]);
                }
            }
        }
        
        return response('Update Successfully.', 200);
    }
}    