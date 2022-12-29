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
        $stok = DB::table('m_stok')
        ->rightjoin('m_produk','m_produk_id','m_stok_m_produk_id')
        ->rightjoin('m_satuan','m_produk_m_satuan_id','m_satuan_id')
        ->where('m_stok_gudang_id',$id)
        ->select('m_stok_awal','m_produk_nama','m_satuan_kode')
        ->get();
        $no = 0;
        $data = array();
        foreach ($stok as $value) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $value->m_produk_nama;
            $row[] = $value->m_stok_awal;
            $row[] = $value->m_satuan_kode;
            $data[] = $row;
        }
        $output = array('data' => $data);
        return response()->json($output);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function simpan(Request $request)
    {
        return $request->all();
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
