<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;

class RekapNotaController extends Controller
{
    public function index()
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass();
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama', 'm_w_id')->where('m_w_id', $waroeng_id)->first();
        $data->area_nama = DB::table('m_area')->join('m_w', 'm_w_m_area_id', 'm_area_id')->select('m_area_nama', 'm_area_id')->where('m_w_id', $waroeng_id)->first();
        $data->akses_area = $this->get_akses_area();//mulai dari 1 - akhir
        $data->akses_pusat = $this->get_akses_pusat();//1,2,3,4,5
        $data->akses_pusar = $this->get_akses_pusar(); //mulai dari 6 - akhir

        $data->waroeng = DB::table('m_w')
            ->where('m_w_m_area_id', $data->area_nama->m_area_id)
            ->orderby('m_w_id', 'ASC')
            ->get();
        $data->area = DB::table('m_area')
            ->orderby('m_area_id', 'ASC')
            ->get();
        $data->user = DB::table('users')
            ->orderby('id', 'ASC')
            ->get();
        $data->transaksi_rekap = DB::table('rekap_transaksi')
            ->select('r_t_id')
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
            ->join('rekap_transaksi', 'r_t_created_by', 'users_id')
            ->select('users_id', 'name');
            if(in_array(Auth::user()->waroeng_id, $this->get_akses_area())){
                $user->where('waroeng_id', $request->id_waroeng);
            } else {
                $user->where('waroeng_id', Auth::user()->waroeng_id);
            }
            if (strpos($request->tanggal, 'to') !== false) {
                [$start, $end] = explode('to' ,$request->tanggal);
                $user->whereBetween('r_t_tanggal', [$start, $end]);
            } else {
                $user->where('r_t_tanggal', $request->tanggal);
            }
            $user1 = $user->orderBy('users_id', 'asc')
            ->get();
        $data = array();
        foreach ($user1 as $val) {
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
                ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
                ->selectRaw('(SUM(r_t_detail_reguler_price * r_t_detail_qty)) as sum_detail, r_t_detail_r_t_id');
                if($request->operator != 'all'){
                    $detail->where('r_t_created_by', $request->operator);
                }
                if (strpos($request->tanggal, 'to') !== false) {
                    [$start, $end] = explode('to' ,$request->tanggal);
                    $detail->whereBetween('r_t_tanggal', [$start, $end]);
                } else {
                    $detail->where('r_t_tanggal', $request->tanggal);
                }
                $detail = $detail->groupby('r_t_detail_r_t_id')
                ->get();

        $get = DB::table('rekap_transaksi')
                ->join('users', 'users_id', 'r_t_created_by')
                ->join('m_transaksi_tipe', 'm_t_t_id', 'r_t_m_t_t_id')
                ->where('r_t_m_w_id', $request->waroeng);
                if($request->operator != 'all'){
                    $get->where('r_t_created_by', $request->operator);
                }
                if (strpos($request->tanggal, 'to') !== false) {
                    [$start, $end] = explode('to' ,$request->tanggal);
                    $get->whereBetween('r_t_tanggal', [$start, $end]);
                } else {
                    $get->where('r_t_tanggal', $request->tanggal);
                }
                $get2 = $get->orderBy('r_t_tanggal', 'ASC')
                ->orderBy('r_t_nota_code', 'ASC')
                ->get();

            $data = array();
            foreach ($get2 as $key => $value) {
                $row = array();
                $row[] = date('d-m-Y', strtotime($value->r_t_tanggal));
                $row[] = date('H:i', strtotime($value->r_t_jam));
                $row[] = $value->name;
                $row[] = $value->r_t_nota_code;
                $row[] = $value->r_t_bigboss;
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
