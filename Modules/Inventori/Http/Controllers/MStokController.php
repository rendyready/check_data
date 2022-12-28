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
       
        $gudang = DB::table('m_gudang')
        ->join('m_w','m_w_id','m_gudang_m_w_id')
        ->select('m_gudang_id','m_gudang_nama','m_w_nama')->get();
        $waroeng_id = Auth::user()->waroeng_id;
        $tgl_now = Carbon::now()->format('Y-m-d');
        return view('inventori::form_stok_awal',compact('gudang','tgl_now'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function list($id)
    {
        $data = DB::table('m_stok')->where('m_stok_gudang_id',$id)->get();
        $output = array('data' => $data);
        return response()->json($output);
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
