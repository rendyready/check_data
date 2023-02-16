<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;

class RekapNotaHarianController extends Controller
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
        return view('dashboard::rekap_nota_harian', compact('data'));
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
        }
        return response()->json($data);
    }

    public function create()
    {
        return view('dashboard::create');
    }

    public function show(Request $request)
    {
        $dates = explode('to' ,$request->tanggal);
        $get = DB::table('rekap_transaksi')
                ->join('rekap_transaksi_detail', 'r_t_detail_sync_id', 'r_t_sync_id')
                ->where('r_t_m_w_id', $request->waroeng)
                ->whereBetween('r_t_tanggal', $dates)
                ->select(DB::Raw('sum(r_t_nominal) as r_t_nominal'))                  
                ->groupBy('r_t_tanggal')
                ->orderBy('r_t_id', 'ASC')
                ->get();
        $data = array();
        foreach ($get as $value) {
            $row = array();
            $row[] = date('d-m-Y', strtotime($value->r_t_tanggal));
            $row[] = rupiah($value->r_t_nominal);
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
