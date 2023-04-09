<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as control;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;

class DetailNotaController extends Controller
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
        $data = new \stdClass();
        if($request->status == 'paid'){
        $data->transaksi_rekap1 = DB::table('rekap_transaksi')
            ->join('users', 'users_id', 'r_t_created_by')
            ->join('m_transaksi_tipe', 'm_t_t_id', 'r_t_m_t_t_id')
            ->join('rekap_payment_transaksi', 'r_p_t_r_t_id', 'r_t_id')
            ->join('m_payment_method', 'm_payment_method_id', 'r_p_t_m_payment_method_id')
            ->where('r_t_m_w_id', $request->waroeng)
            ->where('r_t_status', 'paid');
            if($request->operator != 'all'){
                $data->transaksi_rekap1->where('r_t_created_by', $request->operator);
            }
            if (strpos($request->tanggal, 'to') !== false) {
                $dates = explode('to' ,$request->tanggal);
                $data->transaksi_rekap1->whereBetween('r_t_tanggal', $dates);
            } else {
                $data->transaksi_rekap1->where('r_t_tanggal', $request->tanggal);
            }
            $data->transaksi_rekap = $data->transaksi_rekap1->orderby('r_t_tanggal', 'ASC')
                ->orderby('r_t_nota_code', 'ASC')
                ->get();
        $data->detail_nota = DB::table('rekap_transaksi_detail')
            ->join('m_produk', 'm_produk_id', 'r_t_detail_m_produk_id')
            ->join('m_jenis_produk', 'm_jenis_produk_id', 'm_produk_m_jenis_produk_id')
            ->where('r_t_detail_status', 'paid')
            ->orderby('m_jenis_produk_urut', 'ASC')
            ->orderby('r_t_detail_m_produk_nama', 'ASC')
            ->get();

        } else {

        $data->transaksi_rekap2 = DB::table('rekap_lost_bill')
            ->join('users', 'users_id', 'r_l_b_created_by')
            ->where('r_l_b_m_w_id', $request->waroeng);
            if (strpos($request->tanggal, 'to') !== false) {
                $dates = explode('to' ,$request->tanggal);
                $data->transaksi_rekap2->whereBetween('r_l_b_tanggal', $dates);
            } else {
                $data->transaksi_rekap2->where('r_l_b_tanggal', $request->tanggal);
            }
            if($request->operator != 'all'){
                $data->transaksi_rekap2->where('r_l_b_created_by', $request->operator);
            }
            $data->transaksi_rekap = $data->transaksi_rekap2->get();

        $data->detail_nota = DB::table('rekap_lost_bill_detail')
            ->join('m_produk', 'm_produk_id', 'r_l_b_detail_m_produk_id')
            ->join('m_jenis_produk', 'm_jenis_produk_id', 'm_produk_m_jenis_produk_id')
            ->get();
        }
        return response()->json($data);
    }
}
