<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use illuminate\Support\Str;

class AksesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = DB::table('roles')->get();
        return view('users::akses', compact('data'));
    }
    public function action(Request $request)
    {
        if ($request->ajax()) {
            $upper = Str::upper($request->name);
            $check = DB::table('roles')->whereRaw("UPPER(name)='{$upper}'")->first();
            if (!empty($check->name)) {
                $request->validate(['name']);
                if ($request->action == 'add') {
                    $data = array(
                        'name'    =>    $request->name,
                        'guard_name' => 'web',
                        'created_at' => Carbon::now(),
                    );
                    DB::table('roles')->insert($data);
                } elseif ($request->action == 'edit') {
                    $data = array(
                        'name'    =>    $request->name,
                        'guard_name' => 'web',
                        'updated_at' => Carbon::now(),
                    );
                    DB::table('roles')->where('id', $request->id)
                        ->update($data);
                } else {
                    return 'Nama Duplicate';
                }
                return response()->json($request);
            }
        }
    }
}
