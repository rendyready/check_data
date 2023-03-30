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

    public function show(Request $request)
    {
        
        $payment = DB::table('rekap_payment_transaksi')
                ->join('m_payment_method', 'm_payment_method_id', 'r_p_t_m_payment_method_id')
                ->get();
        $detail = DB::table('rekap_transaksi_detail')
                ->selectRaw('(SUM(r_t_detail_reguler_price * r_t_detail_qty)) as sum_detail, r_t_detail_r_t_id')
                ->groupby('r_t_detail_r_t_id')
                ->get();
        if (strpos($request->tanggal, 'to') !== false) {
        [$start, $end] = explode('to' ,$request->tanggal);
        $get = DB::table('rekap_transaksi')
                ->join('users', 'users_id', 'r_t_created_by')
                ->join('m_transaksi_tipe', 'm_t_t_id', 'r_t_m_t_t_id')
                ->where('r_t_m_w_id', $request->waroeng);
                if($request->operator != 'all'){
                    $get->where('r_t_created_by', $request->operator);
                }
                $get2 = $get->whereBetween('r_t_tanggal', [$start, $end])
                ->orderBy('r_t_tanggal', 'ASC')
                ->orderBy('r_t_nota_code', 'ASC')
                ->get();
        } else {
            $get = DB::table('rekap_transaksi')
                ->join('users', 'users_id', 'r_t_created_by')
                ->join('m_transaksi_tipe', 'm_t_t_id', 'r_t_m_t_t_id')
                ->where('r_t_m_w_id', $request->waroeng);
                if($request->operator != 'all'){
                    $get->where('r_t_created_by', $request->operator);
                }
                $get2 = $get->where('r_t_tanggal', $request->tanggal)
                ->orderBy('r_t_tanggal', 'ASC')
                ->orderBy('r_t_nota_code', 'ASC')
                ->get();
        }

            $data = array();
            foreach ($get2 as $key => $value) {
                $row = array();
                $row[] = date('d-m-Y', strtotime($value->r_t_tanggal));
                $row[] = $value->name;
                $row[] = $value->r_t_nota_code;
                $row[] = number_format($value->r_t_nominal_pajak);
                $row[] = number_format($value->r_t_nominal);
                $row[] = number_format($value->r_t_nominal_sc);
                $row[] = number_format($value->r_t_nominal_diskon);
                $row[] = number_format($value->r_t_nominal_voucher);
                $row[] = number_format($value->r_t_nominal_tarik_tunai);
                $row[] = number_format($value->r_t_nominal_pembulatan);
                $row[] = number_format($value->r_t_nominal_free_kembalian);   
                $row[] = number_format($value->r_t_nominal_total_bayar - $value->r_t_nominal_free_kembalian - $value->r_t_nominal_pembulatan);
                foreach ($detail as $key => $valDetail) {
                    if($value->r_t_id == $valDetail->r_t_detail_r_t_id){
                        $row[] = number_format($valDetail->sum_detail);
                    }
                }
                if($value->r_t_status == "unpaid"){
                    $row[] = 'Lostbill';
                    $row[] = 'Lostbill';
                } else {
                foreach ($payment as $key => $valpay) {
                    if($valpay->r_p_t_r_t_id == $value->r_t_id){
                        $row[] = ($value->m_t_t_group == 'ojol') ? $value->m_t_t_group : $valpay->m_payment_method_type;
                        $row[] = $valpay->m_payment_method_name;
                    }
                }
            }
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
                ->join('users', 'users_id', 'r_t_created_by')
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
