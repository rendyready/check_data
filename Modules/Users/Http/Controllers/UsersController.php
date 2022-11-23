<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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

        $user = DB::table('model_has_roles')
        ->rightjoin('users','users.id','model_id')
        ->leftjoin('roles','role_id','roles.id')
        ->select('users.id as id','users.name as username','roles.name as rolename','email');
        
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
    public function create()
    {
   
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('users::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('users::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
