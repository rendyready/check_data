<?php

namespace Modules\Inventori\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class MStokController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {   
       
        $waroeng = DB::table('m_w')->select('m_w_id','m_w_nama')->get();
        $waroeng_id = Auth::user()->waroeng_id;
        $tgl_now = Carbon::now()->format('Y-m-d');
        $stok_mw = (empty($request->m_stok_m_w_id)) ? $waroeng_id : $request->m_stok_m_w_id ;
        $gudang = (empty($request->m_stok_gudang)) ? 'gudang utama' : $request->m_stok_gudang ;
        $data = DB::table('m_stok')
        ->where('m_stok_m_w_id',$stok_mw)
        ->where('m_stok_gudang',$gudang)
        ->get();
        return view('inventori::form_stok_awal',compact('waroeng','tgl_now','data','stok_mw','gudang'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function list(Request $request)
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
        return view('inventori::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('inventori::edit');
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
