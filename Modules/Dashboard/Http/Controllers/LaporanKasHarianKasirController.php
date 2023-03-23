<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;

class LaporanKasHarianKasirController extends Controller
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
         return view('dashboard::lap_kas_harian_kasir', compact('data'));
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
             $data[$val->m_w_code] = [$val->m_w_nama];
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
         $modal = DB::table('rekap_modal')
             ->select('rekap_modal_sesi')
             ->where('rekap_modal_m_w_code', $request->id_waroeng)
             ->get();
         $data = array();
         foreach ($user as $valOpr) {
            foreach ($modal as $valMdl){
             $data[$valOpr->users_id.'and'.$valMdl->rekap_modal_sesi] = [$valOpr->name.' - sif '.$valMdl->rekap_modal_sesi];
            }
         }
         return response()->json($data);
     }
 
    //  public function show(Request $request)
    //  {
    //      [$start, $end] = explode('to' ,$request->tanggal);
    //      $startDate = date('Y-m-d H:i:s', strtotime($start));
    //      $endDate = date('Y-m-d H:i:s', strtotime($end));
    //      [$opr, $sesi] = explode('and' ,$request->operator);

    //      $saldoIn = DB::table('rekap_modal')
    //                 ->join('rekap_mutasi_modal', 'r_m_m_rekap_modal_id', 'rekap_modal_id')
    //                 ->join('rekap_transaksi', 'r_t_rekap_modal_id', 'rekap_modal_id')
    //                 ->join('rekap_refund', 'r_r_rekap_modal_id', 'rekap_modal_id')
    //                 ->selectRaw('MAX(rekap_modal_nominal) as rekap_modal_nominal, MAX(rekap_modal_nominal) as rekap_modal_nominal, MAX(rekap_modal_cash) as rekap_modal_cash, SUM(r_m_m_debit) as r_m_m_debit, SUM(r_t_nominal_pembulatan) as r_t_nominal_pembulatan, SUM(r_t_nominal_tarik_tunai) as r_t_nominal_tarik_tunai, SUM(r_t_nominal_free_kembalian) as r_t_nominal_free_kembalian, SUM(r_r_nominal_refund) as r_r_nominal_refund, SUM(r_r_nominal_pembulatan_refund) as r_r_nominal_pembulatan_refund, SUM(r_r_nominal_free_kembalian_refund) as r_r_nominal_free_kembalian_refund, SUM(rekap_modal_cash) as rekap_modal_cash, SUM(rekap_modal_cash_real) as rekap_modal_cash_real, rekap_modal_tanggal, rekap_modal_id')
    //                 ->groupby('rekap_modal_tanggal', 'rekap_modal_id')
    //                 ->where('rekap_modal_m_w_code', $request->waroeng)
    //                 // ->where('rekap_modal_created_by', $opr)
    //                 ->where('rekap_modal_sesi', $sesi)
    //                 ->whereBetween('rekap_modal_tanggal', [$start, $end])
    //                 ->where('rekap_modal_status', '=', 'close')
    //                 ->orderBy('rekap_modal_tanggal', 'ASC')
    //                 ->get();
    //     // $saldoOut = DB::table('rekap_mutasi_modal')
    //     //             // ->join('rekap_modal', 'rekap_modal_id', 'r_m_m_rekap_modal_id')
    //     //             ->select('r_m_m_debit')
    //     //             ->where('r_m_m_m_w_code', $request->waroeng)
    //     //             ->where('r_m_m_created_by', $opr)
    //     //             // ->where('rekap_modal_sesi', $sesi)
    //     //             // ->where('rekap_modal_status', 'close')
    //     //             ->whereBetween('r_m_m_tanggal', [$start, $end])
    //     //             ->get();
    //     // $saldoTrans = DB::table('rekap_transaksi')
    //     //             // ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
    //     //             ->join('rekap_refund', 'r_r_r_t_id', 'r_t_id')
    //     //             ->where('r_t_m_w_code', $request->waroeng)
    //     //             ->where('r_t_created_by', $opr)
    //     //             // ->where('rekap_modal_sesi', $sesi)
    //     //             // ->where('rekap_modal_status', 'close')
    //     //             ->whereBetween('r_t_tanggal', [$start, $end])
    //     //             ->get();
 
    //          $data = array();
    //          foreach ($saldoIn as $key => $val_in) {
               
    //                     $row = array();
    //                     $row[] = date('d-m-Y', strtotime($val_in->rekap_modal_tanggal));
    //                     $row[] = rupiah($val_in->rekap_modal_nominal, 0);
    //                     $row[] = rupiah($val_in->rekap_modal_cash, 0);
    //                         $modal = $val_in->r_m_m_debit;
    //                         $trans = $val_in->r_t_nominal_pembulatan + $val_in->r_t_nominal_tarik_tunai + $val_in->r_t_nominal_free_kembalian;
    //                         $refund = $val_in->r_r_nominal_refund + $val_in->r_r_nominal_pembulatan_refund + $val_in->r_r_nominal_free_kembalian_refund;
    //                         $total = $modal + $trans + $refund;
    //                     $row[] = rupiah($total, 0);
    //                     $row[] = rupiah($val_in->rekap_modal_cash - $total, 0);
    //                     $row[] = rupiah($val_in->rekap_modal_cash_real, 0);
    //                     $row[] = rupiah($val_in->rekap_modal_cash_real - ($val_in->rekap_modal_cash - $total), 0);
    //                     $row[] ='<a id="button_detail" class="btn btn-sm button_detail btn-info" value="'.$val_in->rekap_modal_id.'" title="Detail Nota"><i class="fa-sharp fa-solid fa-file"></i></a>';
    //                     $data[] = $row;
                      
    //             }
 
    //      $output = array("data" => $data);
    //      return response()->json($output);
    //  }
 
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

     public function show(Request $request)
     {
         [$start, $end] = explode('to' ,$request->tanggal);
         $startDate = date('Y-m-d H:i:s', strtotime($start));
         $endDate = date('Y-m-d H:i:s', strtotime($end));
         [$opr, $sesi] = explode('and' ,$request->operator);

        $saldoIn = DB::table('rekap_modal')
                    // ->select('rekap_modal_nominal', 'rekap_modal_cash', 'rekap_modal_cash_real', 'rekap_modal_tanggal', 'rekap_modal_id')
                    ->where('rekap_modal_m_w_code', $request->waroeng)
                    ->where('rekap_modal_created_by', $opr)
                    ->where('rekap_modal_sesi', $sesi)
                    ->whereBetween('rekap_modal_tanggal', [$start, $end])
                    ->where('rekap_modal_status', 'close')
                    ->orderBy('rekap_modal_tanggal', 'ASC')
                    ->get();

        // $saldoOut = DB::table('rekap_mutasi_modal')
        //             // ->join('rekap_modal', 'rekap_modal_id', 'r_m_m_rekap_modal_id')
        //             ->select('r_m_m_debit')
        //             ->where('r_m_m_m_w_code', $request->waroeng)
        //             ->where('r_m_m_created_by', $opr)
        //             // ->where('rekap_modal_sesi', $sesi)
        //             // ->where('rekap_modal_status', 'close')
        //             ->whereBetween('r_m_m_tanggal', [$start, $end])
        //             ->get();

        $saldoRef = DB::table('rekap_refund')
                     ->selectRaw('SUM(r_r_nominal_refund) as r_r_nominal_refund, SUM(r_r_nominal_pembulatan_refund) as r_r_nominal_pembulatan_refund, SUM(r_r_nominal_free_kembalian_refund) as r_r_nominal_free_kembalian_refund, r_r_tanggal, r_r_rekap_modal_id')
                    ->groupby('r_r_tanggal', 'r_r_rekap_modal_id')
                    ->where('r_r_m_w_code', $request->waroeng)
                    ->where('r_r_created_by', $opr)
                    ->whereBetween('r_r_tanggal', [$start, $end])
                    ->get();

        $saldoTrans = DB::table('rekap_transaksi')
                    ->selectRaw('SUM(r_t_nominal_pembulatan) as r_t_nominal_pembulatan, SUM(r_t_nominal_tarik_tunai) as r_t_nominal_tarik_tunai, SUM(r_t_nominal_free_kembalian) as r_t_nominal_free_kembalian, r_t_tanggal, r_t_rekap_modal_id')
                    ->groupby('r_t_tanggal', 'r_t_rekap_modal_id')
                    ->where('r_t_m_w_code', $request->waroeng)
                    ->where('r_t_created_by', $opr)
                    ->whereBetween('r_t_tanggal', [$start, $end])
                    ->get();
 
             $data = array();
             foreach ($saldoIn as $key => $val_in) {
                // foreach ($saldoOut as $key => $val_out) {
                    
                        $row = array();
                        $row[] = date('d-m-Y', strtotime($val_in->rekap_modal_tanggal));
                        $row[] = rupiah($val_in->rekap_modal_nominal, 0);
                        $row[] = rupiah($val_in->rekap_modal_cash, 0);
                        //     $modal = $val_out->r_m_m_debit;
                        $row[] = 0;
                        foreach ($saldoTrans as $key => $val_trans) {
                            foreach ($saldoRef as $key => $val_ref) {
                            if($val_trans->r_t_rekap_modal_id == $val_in->rekap_modal_id){
                            $trans = $val_trans->r_t_nominal_pembulatan + $val_trans->r_t_nominal_tarik_tunai + $val_trans->r_t_nominal_free_kembalian;
                            $refund = $val_ref->r_r_nominal_refund + $val_ref->r_r_nominal_pembulatan_refund + $val_ref->r_r_nominal_free_kembalian_refund;
                            $total = $trans + $refund;
                        $row[] = rupiah($total, 0);
                        $saldoAkhir = $val_in->rekap_modal_cash - $total;
                        $row[] = rupiah($saldoAkhir, 0);
                        $row[] = rupiah($val_in->rekap_modal_cash_real, 0);
                        $row[] = rupiah($val_in->rekap_modal_cash_real - $saldoAkhir, 0);
                        }
                    }
                }
                        $row[] ='<a id="button_detail" class="btn btn-sm button_detail btn-info" value="'.$val_in->rekap_modal_id.'" title="Detail Nota"><i class="fa-sharp fa-solid fa-file"></i></a>';
                        $data[] = $row;
                        
                    // }
                }
 
         $output = array("data" => $data);
         return response()->json($output);
     }
 
}

