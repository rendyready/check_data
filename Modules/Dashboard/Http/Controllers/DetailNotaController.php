<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DetailNotaController extends Controller
{

    public function index()
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
        $user = DB::table('rekap_modal')
            ->join('users', 'users_id', 'rekap_modal_created_by')
            ->select('users_id', 'name');
        if (in_array(Auth::user()->waroeng_id, $this->get_akses_area())) {
            $user->where('rekap_modal_m_w_id', $request->id_waroeng);
        } else {
            $user->where('rekap_modal_m_w_id', Auth::user()->waroeng_id);
        }
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $user->whereBetween('rekap_modal_tanggal', [$start, $end]);
        } else {
            $user->whereDate('rekap_modal_tanggal', '=', $request->tanggal);
        }
        $user1 = $user->orderBy('users_id', 'asc')
            ->get();
        $data = array();
        foreach ($user1 as $val) {
            $data[$val->users_id] = [$val->name];
            $data['all'] = 'all operator';
        }
        return response()->json($data);
    }

    public function show(Request $request)
    {
        $data = new \stdClass();
        if ($request->status == 'paid') {
            $transaksi_rekap = DB::table('rekap_transaksi')
                ->join('users', 'users_id', 'r_t_created_by')
                ->join('m_transaksi_tipe', 'm_t_t_id', 'r_t_m_t_t_id')
                ->join('rekap_payment_transaksi', 'r_p_t_r_t_id', 'r_t_id')
                ->join('m_payment_method', 'm_payment_method_id', 'r_p_t_m_payment_method_id')
                ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
                ->where('rekap_modal_status', 'close')
                ->where('r_t_m_w_id', $request->waroeng)
                ->where('r_t_status', 'paid')
                ->select('r_t_nota_code'
                    , 'm_t_t_name'
                    , 'r_t_tanggal'
                    , 'name'
                    , 'r_t_nominal'
                    , 'r_t_nominal_pajak'
                    , 'r_t_nominal_sc'
                    , 'r_t_nominal_diskon'
                    , 'r_t_nominal_voucher'
                    , 'r_t_nominal_tarik_tunai'
                    , 'r_t_nominal_pembulatan'
                    , 'r_t_nominal_free_kembalian'
                    , 'm_payment_method_type'
                    , 'r_t_nominal_total_bayar'
                    , 'r_t_id');
            if ($request->operator != 'all') {
                $transaksi_rekap->where('r_t_created_by', $request->operator);
            }
            if (strpos($request->tanggal, 'to') !== false) {
                $dates = explode('to', $request->tanggal);
                $transaksi_rekap->whereBetween('r_t_tanggal', $dates);
            } else {
                $transaksi_rekap->where('r_t_tanggal', $request->tanggal);
            }
            $data->transaksi_rekap = $transaksi_rekap->orderby('r_t_tanggal', 'ASC')
                ->orderby('r_t_nota_code', 'ASC')
                ->get();

            $detail_nota = DB::table('rekap_transaksi_detail')
                ->join('m_produk', 'm_produk_id', 'r_t_detail_m_produk_id')
                ->join('m_jenis_produk', 'm_jenis_produk_id', 'm_produk_m_jenis_produk_id')
                ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
                ->select('r_t_detail_r_t_id'
                    , 'r_t_detail_m_produk_nama'
                    , 'r_t_detail_qty'
                    , 'r_t_detail_price'
                    , 'r_t_detail_nominal');
            if ($request->operator != 'all') {
                $detail_nota->where('r_t_created_by', $request->operator);
            }
            if (strpos($request->tanggal, 'to') !== false) {
                $dates = explode('to', $request->tanggal);
                $detail_nota->whereBetween('r_t_tanggal', $dates);
            } else {
                $detail_nota->where('r_t_tanggal', $request->tanggal);
            }
            $data->detail_nota = $detail_nota->orderby('m_jenis_produk_urut', 'ASC')
                ->orderby('r_t_detail_m_produk_nama', 'ASC')
                ->get();

            $garansi = DB::table('rekap_garansi')
                ->join('rekap_transaksi', 'r_t_id', 'rekap_garansi_r_t_id')
                ->select('rekap_garansi_r_t_id'
                    , 'rekap_garansi_m_produk_nama'
                    , 'rekap_garansi_qty'
                    , 'rekap_garansi_price'
                    , 'rekap_garansi_nominal')
                ->where('r_t_m_w_id', $request->waroeng);
            if ($request->operator != 'all') {
                $garansi->where('rekap_garansi_created_by', $request->operator);
            }
            if (strpos($request->tanggal, 'to') !== false) {
                $dates = explode('to', $request->tanggal);
                $garansi->whereBetween('r_t_tanggal', $dates);
            } else {
                $garansi->where('r_t_tanggal', $request->tanggal);
            }
            $data->garansi_notnull = $garansi->first();
            $data->garansi = $garansi->get();

            $refund = DB::table('rekap_refund_detail')
                ->join('rekap_refund', 'r_r_id', 'r_r_detail_r_r_id')
                ->select('r_r_r_t_id'
                    , 'r_r_detail_m_produk_nama'
                    , 'r_r_detail_qty'
                    , 'r_r_detail_price'
                    , 'r_r_detail_nominal')
                ->where('r_r_m_w_id', $request->waroeng);
            if ($request->operator != 'all') {
                $refund->where('r_r_created_by', $request->operator);
            }
            if (strpos($request->tanggal, 'to') !== false) {
                $dates = explode('to', $request->tanggal);
                $refund->whereBetween('r_r_tanggal', $dates);
            } else {
                $refund->where('r_r_tanggal', $request->tanggal);
            }
            $data->refund_notnull = $refund->first();
            $data->refund = $refund->get();

        } else {

            $data->transaksi_rekap2 = DB::table('rekap_lost_bill')
                ->join('users', 'users_id', 'r_l_b_created_by')
                ->join('rekap_modal', 'rekap_modal_id', 'r_l_b_rekap_modal_id')
                ->where('rekap_modal_status', 'close')
                ->where('r_l_b_m_w_id', $request->waroeng);
            if (strpos($request->tanggal, 'to') !== false) {
                $dates = explode('to', $request->tanggal);
                $data->transaksi_rekap2->whereBetween('r_l_b_tanggal', $dates);
            } else {
                $data->transaksi_rekap2->where('r_l_b_tanggal', $request->tanggal);
            }
            if ($request->operator != 'all') {
                $data->transaksi_rekap2->where('r_l_b_created_by', $request->operator);
            }
            $data->transaksi_rekap = $data->transaksi_rekap2->get();

            $detail_nota = DB::table('rekap_lost_bill_detail')
                ->join('m_produk', 'm_produk_id', 'r_l_b_detail_m_produk_id')
                ->join('m_jenis_produk', 'm_jenis_produk_id', 'm_produk_m_jenis_produk_id')
                ->join('rekap_lost_bill', 'r_l_b_id', 'r_l_b_detail_r_l_b_id');
            if (strpos($request->tanggal, 'to') !== false) {
                $dates = explode('to', $request->tanggal);
                $detail_nota->whereBetween('r_l_b_tanggal', $dates);
            } else {
                $detail_nota->where('r_l_b_tanggal', $request->tanggal);
            }
            if ($request->operator != 'all') {
                $detail_nota->where('r_l_b_created_by', $request->operator);
            }
            $data->detail_nota = $detail_nota->get();
        }
        return response()->json($data);
    }
}
