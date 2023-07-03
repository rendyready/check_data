<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RefundController extends Controller
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
        $data->user = DB::table('users')
            ->orderby('id', 'ASC')
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
            $data['all'] = ['all waroeng'];
        }
        return response()->json($data);
    }

    public function select_user(Request $request)
    {
        $user = DB::table('users')
            ->join('rekap_refund', 'r_r_created_by', 'users_id')
            ->select('users_id', 'name');
        if (in_array(Auth::user()->waroeng_id, $this->get_akses_area())) {
            $user->where('waroeng_id', $request->id_waroeng);
        } else {
            $user->where('waroeng_id', Auth::user()->waroeng_id);
        }
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $user->whereBetween('r_r_tanggal', [$start, $end]);
        } else {
            $user->where('r_r_tanggal', $request->tanggal);
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
        $refund = DB::table('rekap_refund')
            ->join('users', 'users_id', 'r_r_created_by')
            ->join('rekap_modal', 'rekap_modal_id', 'r_r_rekap_modal_id')
            ->join('rekap_transaksi', 'r_t_id', 'r_r_r_t_id');
        if (strpos($request->tanggal, 'to') !== false) {
            $dates = explode('to', $request->tanggal);
            $refund->whereBetween('r_r_tanggal', $dates);
        } else {
            $refund->where('r_r_tanggal', $request->tanggal);
        }
        if ($request->area != 'all') {
            $refund->where('r_r_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $refund->where('r_r_m_w_id', $request->waroeng);
                if ($request->operator != 'all') {
                    $refund->where('r_r_created_by', $request->operator);
                }
            }
        }
        $refund = $refund->orderBy('r_t_tanggal', 'ASC')
            ->orderBy('r_r_m_area_id', 'ASC')
            ->orderBy('rekap_modal_sesi', 'ASC')
            ->get();

        $data = array();
        foreach ($refund as $value) {
            // foreach ($transaksi as $valTrans) {
            $valTrans = DB::table('rekap_transaksi')
                ->join('users', 'users_id', 'r_t_created_by')
                ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
                ->where('r_t_id', $value->r_r_r_t_id)
                ->orderBy('r_t_tanggal', 'ASC')
                ->first();
            $approve = DB::table('rekap_refund')
                ->leftjoin('users', 'users_id', 'r_r_approved_by')
                ->select('name')
                ->where('r_r_id', $value->r_r_id)
                ->first();

            // if ($value->r_r_m_w_id == $valTrans->r_t_m_w_id && $value->r_r_rekap_modal_id == $valTrans->r_t_rekap_modal_id && $value->r_r_r_t_id == $valTrans->r_t_id){
            $row = array();
            $row[] = $value->r_r_m_area_nama;
            $row[] = $value->r_r_m_w_nama;
            $row[] = date('d-m-Y', strtotime($valTrans->r_t_tanggal));
            $row[] = date('d-m-Y', strtotime($value->r_r_tanggal));
            $row[] = $valTrans->name;
            $row[] = $value->name;
            $row[] = $approve->name;
            $row[] = $value->rekap_modal_sesi;
            $row[] = $value->r_r_bigboss;
            $row[] = $value->r_r_nota_code;
            $row[] = number_format($valTrans->r_t_nominal);
            $row[] = number_format($value->r_r_nominal_refund);
            $row[] = number_format($valTrans->r_t_nominal_pajak, 0);
            $row[] = number_format($value->r_r_nominal_refund_pajak);
            $row[] = number_format($valTrans->r_t_nominal_sc);
            $row[] = number_format($value->r_r_nominal_refund_sc);
            $row[] = number_format($valTrans->r_t_nominal_pembulatan);
            $row[] = number_format($value->r_r_nominal_pembulatan_refund);
            $row[] = number_format($valTrans->r_t_nominal_free_kembalian);
            $row[] = number_format($value->r_r_nominal_free_kembalian_refund);
            $row[] = number_format($valTrans->r_t_nominal_total_bayar);
            $row[] = number_format($value->r_r_nominal_refund_total);
            $row[] = number_format($valTrans->r_t_nominal_total_bayar - $value->r_r_nominal_refund_total);
            $row[] = '<a id="button_detail" class="btn btn-sm button_detail btn-info" value="' . $value->r_r_id . '" title="Detail Refund"><i class="fa-sharp fa-solid fa-file"></i></a>';
            $data[] = $row;
            // }
            // }
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

}