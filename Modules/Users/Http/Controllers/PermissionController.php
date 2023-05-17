<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use illuminate\Support\Str;
use App\Models\Permission;
class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = Permission::all();
        return view('users::permision',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function action(Request $request)
    {
        if($request->ajax())
    	{
            $name = Str::lower($request->name);
            $check = DB::table('permissions')->where('name',$name)->first();
            if (!empty($check)) {
                return response()->json(['error'=>'Nama Telah Ada']);
            } else {
                if ($request->action == 'add') {
                    $data = array(
                        'name'	=>	$request->name,
                        'guard_name' =>'web',
                        'created_at' => Carbon::now(),
                    );
                    DB::table('permissions')->insert($data);
                } elseif ($request->action == 'edit') {
                    $data = array(
                        'name'	=>	$request->name,
                        'guard_name' =>'web',
                        'updated_at' => Carbon::now(),
                        'permissions_status_sync' => 'send'
                    );
                    DB::table('permissions')->where('id',$request->id)
                    ->update($data);
                }
                return response(['messages' => 'Berhasil Tambah Permission','type' => 'success','action' => 'add']);
            }
    		
    	}
    }

    
}
