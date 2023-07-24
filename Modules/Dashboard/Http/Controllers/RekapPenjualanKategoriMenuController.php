<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekapPenjualanKategoriMenuController extends Controller
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
        $data->payment = DB::table('m_jenis_produk')
            ->orderby('id', 'ASC')
            ->get();
        return view('dashboard::rekap_penj_kategori_menu', compact('data'));
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
        $methodPay = DB::table('m_jenis_produk')
            ->orderBy('m_jenis_produk_id', 'ASC')
            ->get();

        $transaksi = DB::table('rekap_transaksi')
            ->join('m_area', 'm_area_code', 'r_t_m_area_code')
            ->join('m_w', 'm_w_code', 'r_t_m_w_code')
            ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
            ->where('rekap_modal_status', 'close');
        if (strpos($request->tanggal, 'to') !== false) {
            $dates = explode('to', $request->tanggal);
            $transaksi->whereBetween('r_t_tanggal', $dates);
        } else {
            $transaksi->where('r_t_tanggal', $request->tanggal);
        }
        if ($request->area != 'all') {
            $transaksi->where('r_t_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $transaksi->where('r_t_m_w_id', $request->waroeng);
            }
        }
        if ($request->show_operator == 'ya') {
            if ($request->operator != 'all') {
                $transaksi->where('r_t_created_by', $request->operator)
                    ->join('users', 'users_id', 'r_t_created_by')
                    ->select('r_t_tanggal', 'name', 'm_area_nama', 'm_w_nama', 'm_w_id', 'r_t_created_by', 'rekap_modal_sesi', 'm_area_id')
                    ->groupBy('r_t_tanggal', 'name', 'm_area_nama', 'm_w_nama', 'm_w_id', 'r_t_created_by', 'rekap_modal_sesi', 'm_area_id');
            } else {
                $transaksi->join('users', 'users_id', 'r_t_created_by')
                    ->select('r_t_tanggal', 'name', 'm_area_nama', 'm_w_nama', 'm_w_id', 'r_t_created_by', 'rekap_modal_sesi', 'm_area_id')
                    ->groupBy('r_t_tanggal', 'name', 'm_area_nama', 'm_w_nama', 'm_w_id', 'r_t_created_by', 'rekap_modal_sesi', 'm_area_id');
            }
        } else {
            $transaksi->select('r_t_tanggal', 'm_area_nama', 'm_w_nama', 'm_w_id', 'm_area_id')
                ->groupBy('r_t_tanggal', 'm_area_nama', 'm_w_nama', 'm_w_id', 'm_area_id');
        }
        $trans = $transaksi->orderBy('r_t_tanggal', 'ASC')->orderBy('m_area_id', 'ASC')->get();

        $transaksi2 = DB::table('rekap_transaksi')
            ->join('m_area', 'm_area_code', 'r_t_m_area_code')
            ->join('m_w', 'm_w_code', 'r_t_m_w_code')
            ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
            ->join('rekap_transaksi_detail', 'r_t_detail_r_t_id', 'r_t_id')
            ->join('m_produk', 'm_produk_id', 'r_t_detail_m_produk_id');
        if (strpos($request->tanggal, 'to') !== false) {
            $dates = explode('to', $request->tanggal);
            $transaksi2->whereBetween('r_t_tanggal', $dates);
        } else {
            $transaksi2->where('r_t_tanggal', $request->tanggal);
        }
        if ($request->area != 'all') {
            $transaksi2->where('r_t_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $transaksi2->where('r_t_m_w_id', $request->waroeng);
            }
        }
        if ($request->show_operator == 'ya') {
            $transaksi2->selectRaw('m_produk_m_jenis_produk_id, r_t_tanggal, r_t_detail_reguler_price, SUM(r_t_detail_qty) as total, r_t_created_by, m_w_id, m_area_id')
                ->groupBy('r_t_tanggal', 'm_produk_m_jenis_produk_id', 'r_t_detail_reguler_price', 'r_t_created_by', 'm_w_id', 'm_area_id');
        } else {
            $transaksi2->selectRaw('m_produk_m_jenis_produk_id, r_t_tanggal, r_t_detail_reguler_price, SUM(r_t_detail_qty) as total')
                ->groupBy('r_t_tanggal', 'm_produk_m_jenis_produk_id', 'r_t_detail_reguler_price');
        }
        $trans2 = $transaksi2->orderBy('m_produk_m_jenis_produk_id', 'ASC')->get();

        $data = [];
        $i = 1;
        foreach ($trans as $key => $valTrans) {
            $data[$i]['area'] = $valTrans->m_area_nama;
            $data[$i]['waroeng'] = $valTrans->m_w_nama;
            $data[$i]['tanggal'] = date('d-m-Y', strtotime($valTrans->r_t_tanggal));
            if ($request->show_operator == 'ya') {
                $data[$i]['operator'] = $valTrans->name;
                $data[$i]['sesi'] = $valTrans->rekap_modal_sesi;
            }
            $grandTotal = 0;
            foreach ($methodPay as $key => $valPay) {
                $total = 0;
                foreach ($trans2 as $key2 => $valTrans2) {
                    if ($request->show_operator == 'ya') {
                        if ($valPay->m_jenis_produk_id == $valTrans2->m_produk_m_jenis_produk_id && $valTrans2->r_t_tanggal == $valTrans->r_t_tanggal && $valTrans2->r_t_created_by == $valTrans->r_t_created_by) {
                            $total += $valTrans2->total * $valTrans2->r_t_detail_reguler_price;
                        }
                    } else {
                        if ($valPay->m_jenis_produk_id == $valTrans2->m_produk_m_jenis_produk_id && $valTrans2->r_t_tanggal == $valTrans->r_t_tanggal) {
                            $total += $valTrans2->total * $valTrans2->r_t_detail_reguler_price;
                        }
                    }
                }
                $data[$i][$valPay->m_jenis_produk_nama] = number_format($total);
                $grandTotal += $total;
            }
            $data[$i]['Total'] = number_format($grandTotal);
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

    // public function show(Request $request)
    // {
    //     $methodPay = DB::table('m_jenis_produk')
    //             ->orderBy('m_jenis_produk_id', 'ASC')
    //             ->get();

    //     $transaksi = DB::table('rekap_transaksi')
    //             ->join('m_area', 'm_area_code', 'r_t_m_area_code')
    //             ->join('m_w', 'm_w_code', 'r_t_m_w_code')
    //             ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id');
    //             if($request->area != 'all'){
    //                 $transaksi->where('r_t_m_area_id', $request->area);
    //                 if($request->waroeng != 'all') {
    //                     $transaksi->where('r_t_m_w_id', $request->waroeng);
    //                 }
    //             }
    //             if($request->show_operator == 'ya'){
    //                 if($request->operator != 'all'){
    //                 $transaksi->where('r_t_created_by', $request->operator);
    //                 }
    //                 $transaksi->join('users', 'users_id', 'r_t_created_by')
    //                     ->select('r_t_tanggal', 'name', 'm_area_nama', 'm_w_nama', 'm_w_id', 'r_t_created_by', 'rekap_modal_sesi')
    //                      ->groupBy('r_t_tanggal', 'name', 'm_area_nama', 'm_w_nama', 'r_t_created_by', 'rekap_modal_sesi');
    //             } else {
    //                 $transaksi->select('r_t_tanggal', 'm_area_nama', 'm_w_nama')
    //                 ->groupBy('r_t_tanggal', 'm_area_nama', 'm_w_nama');
    //             }
    //             if (strpos($request->tanggal, 'to') !== false) {
    //                 $dates = explode('to' ,$request->tanggal);
    //                 $transaksi->whereBetween('r_t_tanggal', $dates);
    //             } else {
    //                 $transaksi->where('r_t_tanggal', $request->tanggal);
    //             }
    //     $trans = $transaksi->orderBy('r_t_tanggal', 'ASC')->get();

    //     $transaksi->join('rekap_transaksi_detail', 'r_t_detail_r_t_id', 'r_t_id')
    //             ->join('m_produk', 'm_produk_id', 'r_t_detail_m_produk_id');
    //             if (strpos($request->tanggal, 'to') !== false) {
    //                 $dates = explode('to' ,$request->tanggal);
    //                 $transaksi->whereBetween('r_t_tanggal', $dates);
    //             } else {
    //                 $transaksi->where('r_t_tanggal', $request->tanggal);
    //             }
    //             $transaksi->orderBy('m_produk_m_jenis_produk_id', 'ASC');
    //             if($request->show_operator == 'ya'){
    //                 $transaksi->selectRaw('m_produk_m_jenis_produk_id, r_t_tanggal, r_t_detail_reguler_price, SUM(r_t_detail_qty) as total, r_t_created_by')
    //                 ->groupBy('r_t_tanggal', 'm_produk_m_jenis_produk_id', 'r_t_detail_reguler_price', 'r_t_created_by');
    //             } else {
    //                 $transaksi->selectRaw('m_produk_m_jenis_produk_id, r_t_tanggal, r_t_detail_reguler_price, SUM(r_t_detail_qty) as total')
    //                 ->groupBy('r_t_tanggal', 'm_produk_m_jenis_produk_id', 'r_t_detail_reguler_price');
    //             }
    //             $trans2 = $transaksi->get();

    //         $data =[];
    //         $i =1;
    //         foreach ($trans as $key => $valTrans) {
    //             $data[$i]['area'] = $valTrans->m_area_nama;
    //             $data[$i]['waroeng'] = $valTrans->m_w_nama;
    //             $data[$i]['tanggal'] = date('d-m-Y', strtotime($valTrans->r_t_tanggal));
    //             if($request->show_operator == 'ya'){
    //             $data[$i]['operator'] = $valTrans->name;
    //             $data[$i]['sesi'] = $valTrans->rekap_modal_sesi;
    //             }
    //             $grandTotal = 0;
    //             foreach ($methodPay as $key => $valPay) {
    //                 $total = 0;
    //                 foreach ($trans2 as $key2 => $valTrans2) {
    //                     if($request->show_operator == 'ya'){
    //                         if ($valPay->m_jenis_produk_id == $valTrans2->m_produk_m_jenis_produk_id && $valTrans2->r_t_tanggal == $valTrans->r_t_tanggal && $valTrans2->r_t_created_by == $valTrans->r_t_created_by && $valTrans2->m_w_nama == $valTrans->m_w_nama) {
    //                             $total += $valTrans2->total * $valTrans2->r_t_detail_reguler_price;
    //                         }
    //                     } else {
    //                         if ($valPay->m_jenis_produk_id == $valTrans2->m_produk_m_jenis_produk_id && $valTrans2->r_t_tanggal == $valTrans->r_t_tanggal && $valTrans2->m_w_nama == $valTrans->m_w_nama) {
    //                             $total += $valTrans2->total * $valTrans2->r_t_detail_reguler_price;
    //                         }
    //                     }
    //                 }
    //                 $data[$i][$valPay->m_jenis_produk_nama] = number_format($total);
    //                 $grandTotal += $total;
    //             }
    //             $data[$i]['Total'] = number_format($grandTotal);
    //             $i++;
    //         }

    //         $length = count($data);
    //         $convert = array();
    //         for ($i=1; $i <= $length ; $i++) {
    //             array_push($convert,array_values($data[$i]));
    //         }
    //     $output = array("data" => $convert);
    //     return response()->json($output);
    // }
}
