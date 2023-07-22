<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekapNotaHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
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
        $data->payment = DB::table('m_payment_method')
            ->orderby('m_payment_method_id', 'ASC')
            ->get();
        return view('dashboard::rekap_nota_harian', compact('data'));
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
        $methodPay = DB::table('m_payment_method')
            ->orderBy('m_payment_method_id', 'ASC')
            ->get();

        $trans = DB::table('rekap_payment_transaksi')
            ->join('rekap_transaksi', 'r_t_id', 'r_p_t_r_t_id')
            ->join('m_area', 'm_area_id', 'r_t_m_area_id')
            ->join('m_w', 'm_w_id', 'r_t_m_w_id')
            ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
            ->where('rekap_modal_status', 'close');
        if (strpos($request->tanggal, 'to') !== false) {
            $dates = explode('to', $request->tanggal);
            $trans->whereBetween('r_t_tanggal', $dates);
        } else {
            $trans->where('r_t_tanggal', $request->tanggal);
        }
        if ($request->area != 'all') {
            $trans->where('r_t_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $trans->where('r_t_m_w_id', $request->waroeng);
            }
        }
        if ($request->show_operator == 'ya') {
            if ($request->operator != 'all') {
                $trans->where('r_t_created_by', $request->operator);
            }
            $trans->join('users', 'users_id', 'r_t_created_by')
                ->selectRaw('r_t_tanggal, SUM(r_t_nominal_total_bayar) as total, SUM(r_t_nominal_pembulatan) as pembulatan, SUM(r_t_nominal_free_kembalian) as free, name, m_area_nama, m_area_id, m_w_nama, r_t_created_by, rekap_modal_sesi')
                ->groupBy('r_t_tanggal', 'name', 'm_area_nama', 'm_area_id', 'm_w_nama', 'r_t_created_by', 'rekap_modal_sesi')
                ->orderBy('r_t_tanggal', 'ASC')
                ->orderBy('m_area_id', 'ASC')
                ->orderBy('rekap_modal_sesi', 'ASC');
        } else {
            $trans->selectRaw('r_t_tanggal, SUM(r_t_nominal_total_bayar) as total, SUM(r_t_nominal_pembulatan) as pembulatan, SUM(r_t_nominal_free_kembalian) as free, m_area_nama, m_area_id, m_w_nama')
                ->groupBy('r_t_tanggal', 'm_area_nama', 'm_area_id', 'm_w_nama')
                ->orderBy('r_t_tanggal', 'ASC')
                ->orderBy('m_area_id', 'ASC');
        }
        $trans1 = $trans->get();

        if ($request->show_operator == 'ya') {
            $trans->selectRaw('r_p_t_m_payment_method_id, r_t_tanggal, SUM(r_t_nominal_total_bayar) as nominal, SUM(r_t_nominal_pembulatan) as bulat, SUM(r_t_nominal_free_kembalian) as kembali, r_t_created_by')
                ->groupBy('r_t_tanggal', 'r_p_t_m_payment_method_id', 'r_t_created_by');
        } else {
            $trans->selectRaw('r_p_t_m_payment_method_id, r_t_tanggal, SUM(r_t_nominal_total_bayar) as nominal, SUM(r_t_nominal_pembulatan) as bulat, SUM(r_t_nominal_free_kembalian) as kembali')
                ->groupBy('r_t_tanggal', 'r_p_t_m_payment_method_id');
        }
        if (strpos($request->tanggal, 'to') !== false) {
            $dates = explode('to', $request->tanggal);
            $trans->whereBetween('r_t_tanggal', $dates);
        } else {
            $trans->where('r_t_tanggal', $request->tanggal);
        }
        $trans2 = $trans->orderBy('r_p_t_m_payment_method_id', 'ASC')->get();

        $data = [];
        $i = 1;
        foreach ($trans1 as $key => $valTrans) {
            $data[$i]['area'] = $valTrans->m_area_nama;
            $data[$i]['waroeng'] = $valTrans->m_w_nama;
            $data[$i]['tanggal'] = date('d-m-Y', strtotime($valTrans->r_t_tanggal));
            if ($request->show_operator == 'ya') {
                $data[$i]['operator'] = $valTrans->name;
                $data[$i]['sesi'] = $valTrans->rekap_modal_sesi;
            }
            $data[$i]['penjualan'] = number_format($valTrans->total - ($valTrans->pembulatan + $valTrans->free));
            foreach ($methodPay as $key => $valPay) {
                $data[$i][$valPay->m_payment_method_name] = 0;
                foreach ($trans2 as $key => $valTrans2) {
                    if ($request->show_operator == 'ya') {
                        if ($valTrans->r_t_tanggal == $valTrans2->r_t_tanggal && $valPay->m_payment_method_id == $valTrans2->r_p_t_m_payment_method_id && $valTrans->r_t_created_by == $valTrans2->r_t_created_by) {
                            $data[$i][$valPay->m_payment_method_name] = number_format($valTrans2->nominal - ($valTrans2->bulat + $valTrans2->kembali));
                        }
                    } else {
                        if ($valTrans->r_t_tanggal == $valTrans2->r_t_tanggal && $valPay->m_payment_method_id == $valTrans2->r_p_t_m_payment_method_id) {
                            $data[$i][$valPay->m_payment_method_name] = number_format($valTrans2->nominal - ($valTrans2->bulat + $valTrans2->kembali));
                        }
                    }
                }
            }
            $i++;
        }
        $length = count($data);
        $convert = array();
        for ($i = 1; $i <= $length; $i++) {
            array_push($convert, array_values($data[$i]));
        }

        $output = array("data" => $convert);
        return response()->json($output);
    }
}
