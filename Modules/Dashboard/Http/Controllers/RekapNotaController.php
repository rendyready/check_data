<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;

class RekapNotaController extends Controller
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
            ->get();
        return view('dashboard::rekap_nota', compact('data'));
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
                ->join('rekap_transaksi_detail', 'r_t_detail_r_t_id', 'r_t_id')
                ->join('users', 'id', 'r_t_created_by')
                ->join('rekap_payment_transaksi', 'r_p_t_r_t_id', 'r_t_id')
                ->join('m_payment_method', 'm_payment_method_id', 'r_p_t_m_payment_method_id')
                ->select('r_t_tanggal', 'name', 'r_t_nota_code', 'r_t_nominal', 'r_t_nominal_pajak', 'r_t_nominal_total_bayar', 'r_t_id', 'm_payment_method_name', 'm_payment_method_type')
                ->where('r_t_m_w_id', $request->waroeng)
                ->where('r_t_created_by', $request->operator)
                ->whereBetween('r_t_tanggal', $dates)
                ->groupBy('r_t_id', 'name', 'r_t_tanggal', 'm_payment_method_name', 'm_payment_method_type')
                ->orderBy('r_t_tanggal', 'ASC')
                ->orderBy('r_t_nota_code', 'ASC')
                ->get();
        $data = array();
        foreach ($get as $value) {
            $row = array();
            $row[] = date('d-m-Y', strtotime($value->r_t_tanggal));
            $row[] = $value->name;
            $row[] = $value->r_t_nota_code;
            $row[] = rupiah($value->r_t_nominal, 0);
            $row[] = rupiah($value->r_t_nominal_pajak, 0);
            $row[] = rupiah($value->r_t_nominal_total_bayar, 0);
            $row[] = $value->m_payment_method_type;
            $row[] = $value->m_payment_method_name;
            $row[] ='<a id="button_detail" class="btn btn-sm button_detail btn-info" value="'.$value->r_t_id.'" title="Detail Nota"><i class="fa-sharp fa-solid fa-file"></i></a>';
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }


    public function detail($id)
    {
        $data = new \stdClass();
        $data->transaksi_rekap = DB::table('rekap_transaksi')
                ->join('users', 'id', 'r_t_created_by')
                ->join('rekap_payment_transaksi', 'r_p_t_r_t_id', 'r_t_id')
                ->join('m_payment_method', 'm_payment_method_id', 'r_p_t_m_payment_method_id')
                ->join('m_transaksi_tipe', 'm_t_t_id', 'r_t_m_t_t_id')
                ->where('r_t_id', $id)
                ->first();
        $data->detail_nota = DB::table('rekap_transaksi_detail')
            ->where('r_t_detail_r_t_id', $id)
            ->get();
        return response()->json($data);
    }


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
