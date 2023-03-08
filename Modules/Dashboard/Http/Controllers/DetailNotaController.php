<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;

class DetailNotaController extends Controller
{

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
        $data->transaksi_rekap = DB::table('rekap_transaksi')
            ->orderby('r_t_id', 'ASC')
            ->get();
        return view('dashboard::detail_nota', compact('data'));
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
        }
        return response()->json($data);
    }

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
        $dates = explode('to' ,$request->tanggal);
        $data = new \stdClass();
        if($request->status == 'paid'){
        $data->transaksi_rekap = DB::table('rekap_transaksi')
            ->join('users', 'users_id', 'r_t_created_by')
            ->join('m_transaksi_tipe', 'm_t_t_id', 'r_t_m_t_t_id')
            ->join('rekap_payment_transaksi', 'r_p_t_r_t_id', 'r_t_id')
            ->join('m_payment_method', 'm_payment_method_id', 'r_p_t_m_payment_method_id')
            ->where('r_t_m_w_id', $request->waroeng)
            ->where('r_t_created_by', $request->operator)
            ->where('r_t_status', 'paid')
            ->whereBetween('r_t_tanggal', $dates)
            ->orderby('r_t_tanggal', 'ASC')
            ->orderby('r_t_nota_code', 'ASC')
            ->get();
        $data->detail_nota = DB::table('rekap_transaksi_detail')
            ->where('r_t_detail_status', 'paid')
            ->get();
        } else {
        $data->transaksi_rekap = DB::table('rekap_lost_bill')
            ->join('users', 'users_id', 'r_l_b_created_by')
            ->whereBetween('r_l_b_tanggal', $dates)
            ->where('r_l_b_m_w_id', $request->waroeng)
            ->where('r_l_b_created_by', $request->operator)
            ->get();

        $data->detail_nota = DB::table('rekap_lost_bill_detail')
            ->get();
        }
        return response()->json($data);
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
