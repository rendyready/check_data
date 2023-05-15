<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = new \stdClass ();
        $data->num = 1;
        $role = Auth::user()->roles[0]->name;
        $data->waroeng = DB::table('m_w')->select('m_w_id', 'm_w_nama')->get();
        $data->roles = DB::table('roles')->get();
        $user = DB::table('model_has_roles')
            ->rightjoin('users', 'users.users_id', 'model_id')
            ->leftjoin('roles', 'role_id', 'roles.id')
            ->leftjoin('m_w', 'waroeng_id', 'm_w_id')
            ->select('users.users_id as users_id', 'users.name as username', 'roles.name as rolename', 'email', 'm_w_nama');

        if ($role == 'admin' || 'administrator') {
            $data->users = $user->orderBy('users.name', 'ASC')->get();
        } else {
            $data->users = $user->where('roles.name', '!=', 'admin')->orderBy('users.name', 'ASC')->get();
        }
        return view('users::index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function action(Request $request)
    {
        $data = $request->waroeng_akses; // mengambil data dari Select2 dalam format JSON dan mengubahnya menjadi array
        $waroeng_akses = implode(',',$data); // menggabungkan data menjadi string dengan delimiter koma

        if ($request->action == 'add') {
            $data = array(
                'users_id' => $this->getMasterId('users'),
                'name' => strtolower($request->name),
                'email' => strtolower($request->email),
                'password' => Hash::make($request->password),
                'waroeng_id' => $request->waroeng_id,
                'waroeng_akses' => '['.$waroeng_akses.']',
                'created_by' => Auth::id(),
                'created_at' => Carbon::now(),
            );
            DB::table('users')->insert($data);
            $user = DB::table('users')->max('users_id');
            User::where('users_id', $user)->first()->assignRole($request->roles);

        } elseif ($request->action == 'edit') {
            if (!empty($request->password)) {
                $data = array(
                    'name' => strtolower($request->name),
                    'email' => strtolower($request->email),
                    'password' => Hash::make($request->password),
                    'waroeng_id' => $request->waroeng_id,
                    'updated_by' => Auth::id(),
                    'updated_at' => Carbon::now(),
                    'users_status_sync' => 'edit',
                );
            } else {
                $data = array(
                    'name' => strtolower($request->name),
                    'email' => strtolower($request->email),
                    'waroeng_id' => $request->waroeng_id,
                    'updated_by' => Auth::id(),
                    'updated_at' => Carbon::now(),
                    'users_status_sync' => 'edit',
                );
            }

            DB::table('model_has_roles')->where('model_id', $request->id)->delete();
            DB::table('users')->where('id', $request->id)
                ->update($data);
            User::where('users_id', $request->id)->first()->assignRole($request->roles);
        } else {
            $data = array(
                'deleted_at' => Carbon::now(),
                'deleted_by' => Auth::id(),
            );
            DB::table('users')
                ->where('users_id', $request->id)
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
            ->rightjoin('users', 'users.users_id', 'model_id')
            ->leftjoin('roles', 'role_id', 'roles.id')
            ->select('users.users_id as id', 'users.name as name', 'roles.name as roles', 'email', 'waroeng_id', 'waroeng_akses')
            ->where('users.users_id', $id)->first();
        return response()->json($edit, 200);
    }
    public function reset_pass($id)
    {
        DB::table('users')
            ->where('users_id', $id)
            ->update(['password' => Hash::make(123456),
                'verified' => null,
                'users_status_sync' => 'edit']);
        return response()->json(['success' => 'success']);
    }
}
