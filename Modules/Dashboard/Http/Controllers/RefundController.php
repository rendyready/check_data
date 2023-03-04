<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;

class RefundController extends Controller
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
        $data->transaksi_rekap = DB::table('rekap_refund')
            ->get();
        return view('dashboard::rekap_refund', compact('data'));
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
        $dates = explode('to' ,$request->tanggal);
        $get = DB::table('rekap_refund')
                ->join('users', 'users_id', 'r_r_created_by')
                ->join('rekap_transaksi', 'r_t_id', 'r_r_r_t_id')
                ->where('r_r_m_w_id', $request->waroeng)
                ->where('r_r_created_by', $request->operator)
                ->whereBetween('r_r_tanggal', $dates)
                ->orderBy('r_r_tanggal', 'ASC')
                ->orderBy('r_r_nota_code', 'ASC')
                ->get();
        $data = array();
        foreach ($get as $value) {
            $row = array();
            $row[] = date('d-m-Y', strtotime($value->r_t_tanggal));
            $row[] = date('d-m-Y', strtotime($value->r_r_tanggal));
            $row[] = $value->name;
            $row[] = $value->name;
            $row[] = $value->r_r_bigboss;
            $row[] = $value->r_r_nota_code;
            $row[] = rupiah($value->r_t_nominal, 0);
            $row[] = rupiah($value->r_r_nominal_refund, 0);
            $row[] = rupiah($value->r_t_nominal_pajak, 0);
            $row[] = rupiah($value->r_r_nominal_refund_pajak, 0);
            $row[] = rupiah($value->r_t_nominal_sc, 0);
            $row[] = rupiah($value->r_r_nominal_refund_sc, 0);
            $row[] = rupiah($value->r_t_nominal_pembulatan, 0);
            $row[] = rupiah($value->r_r_nominal_pembulatan_refund, 0);
            $row[] = rupiah($value->r_t_nominal_free_kembalian, 0);
            $row[] = rupiah($value->r_r_nominal_free_kembalian_refund, 0);
            $row[] = rupiah($value->r_t_nominal_total_bayar, 0);
            $row[] = rupiah($value->r_r_nominal_refund_total, 0);
            $row[] = rupiah($value->r_t_nominal_total_bayar - $value->r_r_nominal_refund_total, 0);
            $row[] ='<a id="button_detail" class="btn btn-sm button_detail btn-info" value="'.$value->r_r_id.'" title="Detail Refund"><i class="fa-sharp fa-solid fa-file"></i></a>';
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }

    public function detail($id)
    {
        $data = new \stdClass();
        $data->transaksi_rekap = DB::table('rekap_refund')
                ->join('users', 'users_id', 'r_r_created_by')
                ->where('r_r_id', $id)
                ->first();
        $data->detail_nota = DB::table('rekap_refund_detail')
            ->where('r_r_detail_r_r_id', $id)
            ->get();
        return response()->json($data);
    }
   
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
