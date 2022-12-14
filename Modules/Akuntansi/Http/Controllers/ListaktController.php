<?php

namespace Modules\Akuntansi\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ListaktController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = new \stdClass();
        $data->no = 1;
        $data->listakt = DB::table('list_akt')
        ->select('list_akt_nama')
        ->get();
        
        return view('akuntansi::master.list_akt',compact('data'));
  
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function save(Request $request)
    {
        // for($i=$request->mulai_list;$i<=$request->selesai_list;$i++)
        // {
       $data= DB::table('list_akt')->insert([
            'list_akt_nama'=>$request->list_akt_nama,
            'list_akt_created_by'=>Auth::id(),
            'list_akt_created_at'=>Carbon::now(),
        ]);
        // }
        return redirect()->route('rek_list.index');
        
        
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
        return view('akuntansi::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('akuntansi::edit');
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
