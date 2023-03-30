<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;

class GaransiController extends Controller
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
        return view('dashboard::rekap_garansi', compact('data'));
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

    public function select_user(Request $request)
    {
        $user = DB::table('users')
            ->select('users_id', 'name')
            ->where('waroeng_id', $request->id_waroeng)
            ->orderBy('users_id', 'asc')
            ->get();
        $data = array();
        foreach ($user as $val) {
            $data[$val->users_id] = [$val->name];
            $data['all'] = 'All Operator';
        }
        return response()->json($data);
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
    public function show(Request $request)
    {
        if (strpos($request->tanggal, 'to') !== false) {
        $dates = explode('to' ,$request->tanggal);
        $get2 = DB::table('rekap_garansi')
                ->join('rekap_transaksi', 'r_t_id', 'rekap_garansi_r_t_id')
                ->join('users', 'users_id', 'rekap_garansi_created_by')
                ->where('r_t_m_w_id', $request->waroeng)
                ->whereBetween('r_t_tanggal', $dates);
                if($request->operator != 'all'){
                    $get2->where('rekap_garansi_created_by', $request->operator);
                }
                $get = $get2->orderBy('r_t_tanggal', 'ASC')
                ->orderBy('r_t_nota_code', 'ASC')
                ->get();
        } else {
        $get2 = DB::table('rekap_garansi')
            ->join('rekap_transaksi', 'r_t_id', 'rekap_garansi_r_t_id')
            ->join('users', 'users_id', 'rekap_garansi_created_by')
            ->where('r_t_m_w_id', $request->waroeng)
            ->where('r_t_tanggal', $request->tanggal);
            if($request->operator != 'all'){
                $get2->where('rekap_garansi_created_by', $request->operator);
            }
            $get = $get2->orderBy('r_t_tanggal', 'ASC')
            ->orderBy('r_t_nota_code', 'ASC')
            ->get(); 
        }
        $data = array();
        foreach ($get as $value) {
            $row = array();
            $row[] = date('d-m-Y', strtotime($value->r_t_tanggal));
            $row[] = $value->r_t_nota_code;
            $row[] = $value->name;
            $row[] = $value->r_t_bigboss;
            $row[] = $value->rekap_garansi_m_produk_nama;
            $row[] = $value->rekap_garansi_qty;
            $row[] = rupiah($value->rekap_garansi_price, 0);
            $row[] = rupiah($value->rekap_garansi_nominal, 0);
            $row[] = $value->rekap_garansi_keterangan;
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
