<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekapNotaController extends Controller
{
    public function index(Request $request)
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass();
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama', 'm_w_id')->where('m_w_id', $waroeng_id)->first();
        $data->area_nama = DB::table('m_area')->join('m_w', 'm_w_m_area_id', 'm_area_id')->select('m_area_nama', 'm_area_id')->where('m_w_id', $waroeng_id)->first();
        $data->akses_area = $this->get_akses_area(); //mulai dari 1 - akhir
        $data->akses_pusat = $this->get_akses_pusat(); //1,2,3,4,5
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
        $user = DB::table('rekap_transaksi')
            ->join('users', 'r_t_created_by', 'users_id')
            ->select('users_id', 'name');
        if (in_array(Auth::user()->waroeng_id, $this->get_akses_area())) {
            $user->where('r_t_m_w_id', $request->id_waroeng);
        } else {
            $user->where('r_t_m_w_id', Auth::user()->waroeng_id);
        }
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $user->whereBetween('r_t_tanggal', [$start, $end]);
        } else {
            $user->where('r_t_tanggal', $request->tanggal);
        }
        $user1 = $user->orderBy('users_id', 'asc')->get();

        $data = array();
        foreach ($user1 as $val) {
            $data[$val->users_id] = [$val->name];
            $data['all'] = 'all operator';
        }
        return response()->json($data);
    }

    public function show(Request $request)
    {
        $payment = DB::table('rekap_payment_transaksi')
            ->join('m_payment_method', 'm_payment_method_id', 'r_p_t_m_payment_method_id')
            ->join('rekap_transaksi', 'r_t_id', 'r_p_t_r_t_id')
            ->select('m_payment_method_type', 'm_payment_method_name', 'r_p_t_r_t_id');
        if ($request->operator != 'all') {
            $payment->where('r_t_created_by', $request->operator);
        }
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $payment->whereBetween('r_t_tanggal', [$start, $end]);
        } else {
            $payment->where('r_t_tanggal', $request->tanggal);
        }
        if ($request->operator != 'all') {
            $payment->where('r_t_created_by', $request->operator);
        }
        $payment = $payment->get();

        $get = DB::table('rekap_transaksi')
            ->join('rekap_transaksi_detail', 'r_t_detail_r_t_id', 'r_t_id')
            ->join('users', 'users_id', 'r_t_created_by')
            ->join('m_transaksi_tipe', 'm_t_t_id', 'r_t_m_t_t_id')
            ->selectRaw('(SUM(r_t_detail_reguler_price * r_t_detail_qty)) as sum_detail, r_t_tanggal, r_t_jam, name, r_t_nota_code, r_t_bigboss, r_t_nominal_pajak, r_t_nominal, r_t_nominal_sc, r_t_nominal_diskon, r_t_nominal_voucher, r_t_nominal_tarik_tunai, r_t_nominal_pembulatan, r_t_nominal_free_kembalian, r_t_nominal_total_bayar, r_t_nominal_free_kembalian, r_t_nominal_pembulatan, r_t_nominal_selisih, r_t_id, m_t_t_group, r_t_status')
            ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
            ->where('rekap_modal_status', 'close')
            ->where('r_t_m_w_id', $request->waroeng);
        if ($request->operator != 'all') {
            $get->where('r_t_created_by', $request->operator);
        }
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $get->whereBetween('r_t_tanggal', [$start, $end]);
        } else {
            $get->where('r_t_tanggal', $request->tanggal);
        }
        if ($request->operator != 'all') {
            $get->where('r_t_created_by', $request->operator);
        }
        if ($request->status != 'all') {
            $get->whereNot('r_t_nominal_selisih', 0);
        }
        $get2 = $get->groupby('r_t_tanggal', 'r_t_jam', 'name', 'r_t_nota_code', 'r_t_bigboss', 'r_t_nominal_pajak', 'r_t_nominal', 'r_t_nominal_sc', 'r_t_nominal_diskon', 'r_t_nominal_voucher', 'r_t_nominal_tarik_tunai', 'r_t_nominal_pembulatan', 'r_t_nominal_free_kembalian', 'r_t_nominal_total_bayar', 'r_t_nominal_free_kembalian', 'r_t_nominal_pembulatan', 'r_t_nominal_selisih', 'r_t_id', 'm_t_t_group', 'r_t_status')
            ->orderBy('r_t_tanggal', 'ASC')
            ->orderBy('r_t_nota_code', 'ASC')
            ->get();

        $error_respon = 0;
        $errorDetected = false;
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
            $row[] = number_format($value->sum_detail);
            if ($value->r_t_status == "unpaid") {
                $row[] = 'Lostbill';
                $row[] = 'Lostbill';
            } else {
                $paymentMethodFound = false;
                foreach ($payment as $key => $valpay) {
                    if ($valpay->r_p_t_r_t_id == $value->r_t_id) {
                        $paymentMethodFound = true;
                        $row[] = ($value->m_t_t_group == 'ojol') ? $value->m_t_t_group : $valpay->m_payment_method_type;
                        $row[] = $valpay->m_payment_method_name;
                    }

                }
                if ($paymentMethodFound == false) {
                    $errorDetected = true;
                    $row[] = '<span style="background-color: #ffcccc;">Error</span>';
                    $row[] = '<span style="background-color: #ffcccc;">Error</span>';
                }
            }
            $row[] = number_format($value->r_t_nominal_selisih);
            $row[] = '<a id="button_detail" class="btn btn-sm button_detail btn-info" value="' . $value->r_t_id . '" title="Detail Nota"><i class="fa-sharp fa-solid fa-file"></i></a>';
            $data[] = $row;
        }
        if ($errorDetected == true) {
            $error_respon = 1;
        }

        $output = array(
            "data" => $data,
            "error" => $error_respon,
        );
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

        $garansi = DB::table('rekap_garansi')
            ->where('rekap_garansi_r_t_id', $id);
        $data->garansi = $garansi->get();
        $garansi_notnull = $garansi->first();

        $refund = DB::table('rekap_refund_detail')
            ->join('rekap_refund', 'r_r_id', 'r_r_detail_r_r_id')
            ->where('r_r_r_t_id', $id);
        $data->refund = $refund->get();
        $refund_notnull = $refund->first();

        return response()->json($data);
    }

}