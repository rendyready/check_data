<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use App\Models\User;
use Carbon\Carbon;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {   
        $data = new \stdClass();
        $data->num = 1;
        $role = Auth::user()->roles[0]->name;
        $data->waroeng = DB::table('m_w')->select('m_w_id','m_w_nama')->get();
        $data->roles = DB::table('roles')->get();
        $user = DB::table('model_has_roles')
        ->rightjoin('users','users.id','model_id')
        ->leftjoin('roles','role_id','roles.id')
        ->leftjoin('m_w','waroeng_id','m_w_id')
        ->select('users.id as id','users.name as username','roles.name as rolename','email','m_w_nama');
        
        if ($role == 'admin'||'administrator') {
            $data->users = $user->orderBy('users.name','ASC')->get();
        }else{
            $data->users = $user->where('roles.name','!=','admin')->orderBy('users.name','ASC')->get();
        }
        return view('users::index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function action(Request $request)
    {
        // $rules = [
        //     'email' => 'required|unique:users|max:255'

        // ];
        // $data_validate = array(
        //     'email'	=>	strtolower($request->email)
        // );
        // $validator = \Validator::make($data_validate,$rules);
        // if ($validator->fails()) {
        //     return response()->json(['error'=>true, 'message'=>$validator->messages()->get('*')]);
        // }
            if ($request->action == 'add') {
                $data = array(
                    'name'    =>    strtolower($request->name),
                    'email'    =>    strtolower($request->email),
                    'password'    =>    Hash::make($request->password),
                    'waroeng_id' => $request->waroeng_id,
                    'created_by' => Auth::id(),
                    'created_at' => Carbon::now(),
                );
                DB::table('users')->insert($data);
                $user = DB::table('users')->max('id');
               User::where('id', $user)->first()->assignRole($request->roles);
                
            } elseif ($request->action == 'edit') {
               if (!empty($request->password)) {
                $data = array(
                    'name'    =>    strtolower($request->name),
                    'email'    =>    strtolower($request->email),
                    'password' => Hash::make($request->password),
                    'waroeng_id' => $request->waroeng_id,
                    'updated_by' => Auth::id(),
                    'updated_at' => Carbon::now(),
                );
               } else {
                $data = array(
                    'name'    =>    strtolower($request->name),
                    'email'    =>    strtolower($request->email),
                    'waroeng_id' => $request->waroeng_id,
                    'updated_by' => Auth::id(),
                    'updated_at' => Carbon::now(),
                );
               }
               
                DB::table('model_has_roles')->where('model_id',$request->id)->delete();
                DB::table('users')->where('id', $request->id)
                    ->update($data);
                User::where('id', $request->id)->first()->assignRole($request->roles);
            } else {
                $data = array(
                    'deleted_at' => Carbon::now(),
                    'deleted_by' => Auth::id()
                );
                DB::table('users')
                    ->where('id', $request->id)
                    ->update($data);
            }
            return response()->json($request);
        
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $edit = DB::table('model_has_roles')
        ->rightjoin('users','users.id','model_id')
        ->leftjoin('roles','role_id','roles.id')
        ->select('users.id as id','users.name as name','roles.name as roles','email','waroeng_id')
        ->where('users.id',$id)->first();
         return response()->json($edit, 200);
    }
}
