<?php

namespace Modules\Inventori\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class ChtController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {   
        $data = new \stdClass();
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $waroeng_id = Auth::user()->waroeng_id;
        $data->nama_waroeng = DB::table('m_w')->select('m_w_nama')->where('m_w_id',$waroeng_id)->first();
        $data->satuan = DB::table('m_satuan')->get();
        $data->cht = DB::table('rekap_beli_detail')
        ->select('rekap_beli_detail_id','rekap_beli_supplier_nama','rekap_beli_detail_m_produk_nama',
                 'rekap_beli_detail_catatan','rekap_beli_detail_qty','m_satuan_kode')
        ->leftjoin('rekap_beli','rekap_beli_code','rekap_beli_detail_rekap_beli_code')
        ->leftjoin('m_produk','rekap_beli_detail_m_produk_id','m_produk_id')
        ->leftjoin('m_satuan','m_produk_m_satuan_id','m_satuan_id')
        ->where('rekap_beli_tgl',$data->tgl_now)
        ->where('rekap_beli_m_w_id',$waroeng_id)
        ->get();
        return view('inventori::form_cht',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('inventori::create');
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
