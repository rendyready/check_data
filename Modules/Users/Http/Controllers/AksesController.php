<?php

namespace Modules\Users\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;

class AksesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = DB::table('roles')->get();
        $permision = Permission::all();
        return view('users::akses', compact('data', 'permision'));
    }
    public function action(Request $request)
    {
        if ($request->ajax()) {
            $name = Str::lower($request->name);
            $check = DB::table('roles')->where('name', $name)->first();
            if ($request->action == 'permission_edit') {
                $role = Role::updateOrCreate(
                    ['name' => $request->name],
                    ['guard_name' => 'web']// Add additional fields if needed
                );
                $permissions = $request->input('permission_id', []);
                $role->permissions()->sync($permissions);
                Artisan::call('cache:clear');
                return response()->json(['messages' => 'Permission Berhasil Berubah', 'type' => 'success']);
            } else {
                if (!empty($check)) {
                    return response()->json(['messages' => 'Nama Telah Ada', 'type' => 'danger']);
                } else {
                    if ($request->action == 'add') {
                        $data = array(
                            'name' => $request->name,
                            'guard_name' => 'web',
                            'created_at' => Carbon::now(),
                        );
                        DB::table('roles')->insert($data);
                    } elseif ($request->action == 'edit') {
                        $data = array(
                            'name' => $request->name,
                            'guard_name' => 'web',
                            'updated_at' => Carbon::now(),
                            'roles_status_sync' => 'send',
                            'roles_client_target' => DB::raw('DEFAULT'),
                        );
                        DB::table('roles')->where('id', $request->id)
                            ->update($data);
                        return response()->json(['messages' => 'Role Berhasil Dirubah', 'type' => 'success']);
                    }
                }
            }

        }
    }
    public function edit($id)
    {
        $data = DB::table('roles')->where('id', $id)->first();
        return response()->json($data);
    }
    public function rolehaspermission($id)
    {
        $permissions = DB::table('role_has_permissions')
            ->where('role_id', $id)
            ->pluck('permission_id')
            ->toArray();

        $role = DB::table('roles')
            ->where('id', $id)
            ->first();

        return response()->json(['permissions' => $permissions, 'role' => $role]);

    }
}
