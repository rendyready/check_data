<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;

class RekapMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = new \stdClass();
        $data->waroeng = DB::table('m_w')
            ->orderby('m_w_id', 'ASC')
            ->get();
        $data->area = DB::table('m_area')
            ->orderby('m_area_id', 'ASC')
            ->get();
        $data->user = DB::table('users')
            ->orderby('id', 'ASC')
            ->get();
        return view('dashboard::rekap_menu', compact('data'));
    }

    public function select_waroeng(Request $request)
    {

        $waroeng = DB::table('m_w')
            ->select('m_w_id', 'm_w_nama', 'm_w_code')
            ->where('m_w_m_area_id', $request->id_area)
            ->orderBy('m_w_id', 'asc')
            ->get();
        $data = array();
        foreach ($waroeng as $val) {
            $data[$val->m_w_id] = [$val->m_w_nama];
            $data['all'] = ['all waroeng'];
        }
        return response()->json($data);
    }

    public function create()
    {
        return view('dashboard::create');
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

    public function show(Request $request)
    {
        $dates = explode('to' ,$request->tanggal);
        $get = DB::table('rekap_transaksi_detail')
                ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
                ->selectRaw('r_t_tanggal, r_t_detail_m_produk_id, r_t_detail_m_produk_nama, sum(r_t_detail_qty) as qty, sum(r_t_detail_nominal) as nominal');
                if($request->area != 0) {
                    $get->where('r_t_m_area_id', $request->area);
                    if($request->waroeng != 'all') {
                        $get->where('r_t_m_w_id', $request->waroeng);
                    }
                }
                $get2= $get->whereBetween('r_t_tanggal', $dates)
                            ->groupBy('r_t_tanggal', 'r_t_detail_m_produk_id', 'r_t_detail_m_produk_nama')
                            ->orderBy('r_t_tanggal', 'ASC')
                            ->orderBy('r_t_detail_m_produk_id', 'ASC')
                            ->get();
        $data = array();
        foreach ($get2 as $value) {
            $row = array();
            $row[] = $value->r_t_tanggal;
            $row[] = $value->r_t_detail_m_produk_nama;
            $row[] = $value->qty;
            $row[] = rupiah($value->nominal, 0);
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }
    

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('dashboard::edit');
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
