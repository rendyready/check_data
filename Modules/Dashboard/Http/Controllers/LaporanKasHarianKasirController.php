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
 
    public function detail($id)
    {
        // $data = new \stdClass();
        $data = DB::table('rekap_modal')
            ->join('users', 'users_id', 'rekap_modal_created_by')
            ->where('rekap_modal_id', $id)
            ->first();

        return response()->json($data);
    }

    public function detail_show(Request $request, $id)
    {
        [$start, $end] = explode('to' ,$request->tanggal);
        [$opr, $sesi] = explode('and' ,$request->operator);
        
        $modal = DB::table('rekap_modal')
            ->where('rekap_modal_m_w_code', $request->waroeng)
            ->where('rekap_modal_created_by', $opr)
            ->where('rekap_modal_sesi', $sesi)
            ->whereBetween('rekap_modal_tanggal', [$start, $end])
            ->where('rekap_modal_id', $id)
            ->orderby('rekap_modal_tanggal', 'ASC')
            ->get();
        $mutasi = DB::table('rekap_mutasi_modal')
            ->where('r_m_m_m_w_code', $request->waroeng)
            ->where('r_m_m_created_by', $opr)
            ->whereBetween('r_m_m_tanggal', [$start, $end])
            ->where('r_m_m_rekap_modal_id', $id)
            ->orderby('r_m_m_tanggal', 'ASC')
            ->orderby('r_m_m_jam', 'ASC')
            ->get();
        $transaksi = DB::table('rekap_transaksi')
            ->where('r_t_m_w_code', $request->waroeng)
            ->where('r_t_created_by', $opr)
            ->whereBetween('r_t_tanggal', [$start, $end])
            ->where('r_t_rekap_modal_id', $id)
            ->orderby('r_t_tanggal', 'ASC')
            ->orderby('r_t_jam', 'ASC')
            ->get();
        $refund = DB::table('rekap_refund')
            ->where('r_r_m_w_code', $request->waroeng)
            ->where('r_r_created_by', $opr)
            ->whereBetween('r_r_tanggal', [$start, $end])
            ->where('r_r_rekap_modal_id', $id)
            ->orderby('r_r_tanggal', 'ASC')
            ->orderby('r_r_jam', 'ASC')
            ->get();
        $lostbill = DB::table('rekap_lost_bill')
            ->where('r_l_b_m_w_code', $request->waroeng)
            ->where('r_l_b_created_by', $opr)
            ->whereBetween('r_l_b_tanggal', [$start, $end])
            ->where('r_l_b_rekap_modal_id', $id)
            ->orderby('r_l_b_tanggal', 'ASC')
            ->orderby('r_l_b_jam', 'ASC')
            ->get();

    
    $data = array();
    foreach ($modal as $valModal) {
        $data[] = array(
            'tanggal' => date('d-m-Y', strtotime($valModal->rekap_modal_tanggal)),
            'no nota' => $valModal->rekap_modal_id,
            'transaksi' => 'Modal awal',
            'masuk' => 0,
            'keluar' => 0,
            'saldo' => rupiah($valModal->rekap_modal_nominal, 0),
        );
    $totalKeluar = 0;
    $totalMasuk = 0;
    $prevSaldoMut = 0;
    foreach ($mutasi as $row) {
        if ($row->r_m_m_debit != 0) {
            $masuk = $row->r_m_m_debit . ", ";
            $modal = $valModal->rekap_modal_nominal - $row->r_m_m_debit;
            $tnp_modal = $prevSaldoMut - $row->r_m_m_debit;
            $saldo = $prevSaldoMut == 0 ? $modal : $tnp_modal;
            $data[] = array(
                'tanggal' => date('d-m-Y', strtotime($row->r_t_tanggal)),
                'no nota' =>$row->r_t_nota_code,
                'transaksi' =>$row->r_m_m_keterangan,
                'masuk' => rupiah($masuk, 0),
                'keluar' => 0,
                'saldo' => rupiah($saldo, 0),
            );
            $totalKeluar += $row->r_m_m_debit;
            $prevSaldoMut = $saldo;
        }
        if ($row->r_m_m_kredit != 0) {
            $masuk = $row->r_m_m_kredit . ", ";
            $saldo = $prevSaldoMut + $row->r_m_m_kredit;
            $data[] = array(
                'tanggal' => date('d-m-Y', strtotime($row->r_t_tanggal)),
                'no nota' =>$row->r_t_nota_code,
                'transaksi' =>$row->r_m_m_keterangan,
                'masuk' => rupiah($masuk, 0),
                'keluar' => 0,
                'saldo' => rupiah($saldo, 0),
            );
            $totalMasuk += $row->r_m_m_kredit;
            $prevSaldoMut = $saldo;
        }
    }
    $prevSaldo = 0;
    foreach ($transaksi as $row) {
        if ($row->r_t_nominal != 0) {
            $masuk = rupiah($row->r_t_nominal, 0) . ", ";
            $trans_nom_mdl = $valModal->rekap_modal_nominal + $row->r_t_nominal;
            $trans_nom = $prevSaldo + $row->r_t_nominal;
            $saldo = $prevSaldo == 0 ? $trans_nom_mdl : $trans_nom;
            $data[] = array(
                'tanggal' => date('d-m-Y', strtotime($row->r_t_tanggal)),
                'no nota' =>$row->r_t_nota_code,
                'transaksi' =>'Transaksi',
                'masuk' => $masuk,
                'keluar' => 0,
                'saldo' => rupiah($saldo, 0),
            );
            $prevSaldo = $saldo;
            $totalMasuk += $row->r_t_nominal;
        }
        if ($row->r_t_nominal_pajak != 0) {
            $masuk = rupiah($row->r_t_nominal_pajak, 0) . ", ";
            $trans_pajak = $prevSaldo + $row->r_t_nominal_pajak;
            $data[] = array(
                'tanggal' => date('d-m-Y', strtotime($row->r_t_tanggal)),
                'no nota' =>$row->r_t_nota_code,
                'transaksi' =>'Pajak',
                'masuk' => $masuk,
                'keluar' => 0,
                'saldo' => rupiah($trans_pajak, 0),
            );
            $prevSaldo = $trans_pajak;
            $totalMasuk += $row->r_t_nominal_pajak;
        }
        if ($row->r_t_nominal_sc != 0) {
            $masuk = rupiah($row->r_t_nominal_sc, 0) . ", ";
            $trans_sc = $prevSaldo + $row->r_t_nominal_sc;
            $data[] = array(
                'tanggal' => date('d-m-Y', strtotime($row->r_t_tanggal)),
                'no nota' =>$row->r_t_nota_code,
                'transaksi' =>'Servis Charge',
                'masuk' => $masuk,
                'keluar' => 0,
                'saldo' => rupiah($trans_sc, 0),
            );
            $prevSaldo = $trans_sc;
            $totalMasuk += $row->r_t_nominal_sc;
        }
        if ($row->r_t_nominal_diskon != 0) {
            $masuk = rupiah($row->r_t_nominal_diskon, 0) . ", ";
            $trans_diskon = $prevSaldo + $row->r_t_nominal_diskon;
            $data[] = array(
                'tanggal' => date('d-m-Y', strtotime($row->r_t_tanggal)),
                'no nota' =>$row->r_t_nota_code,
                'transaksi' =>'Voucher',
                'masuk' => $masuk,
                'keluar' => 0,
                'saldo' => rupiah($trans_diskon, 0),
            );
            $prevSaldo = $trans_diskon;
            $totalMasuk += $row->r_t_nominal_diskon;
        }
        if ($row->r_t_nominal_voucher != 0) {
            $masuk = rupiah($row->r_t_nominal_voucher, 0) . ", ";
            $trans_voucer = $prevSaldo + $row->r_t_nominal_voucher;
            $data[] = array(
                'tanggal' => date('d-m-Y', strtotime($row->r_t_tanggal)),
                'no nota' =>$row->r_t_nota_code,
                'transaksi' =>'Voucher',
                'masuk' => $masuk,
                'keluar' => 0,
                'saldo' => rupiah($trans_voucer, 0),
            );
            $prevSaldo = $trans_voucer;
            $totalMasuk += $row->r_t_nominal_voucher;
        }
        if ($row->r_t_nominal_pembulatan != 0) {
            $keluar = rupiah($row->r_t_nominal_pembulatan, 0) . ", ";
            $trans_bulat = $prevSaldo - $row->r_t_nominal_pembulatan;
            $data[] = array(
                'tanggal' => date('d-m-Y', strtotime($row->r_t_tanggal)),
                'no nota' =>$row->r_t_nota_code,
                'transaksi' =>'Pembualatan',
                'masuk' => 0,
                'keluar' => $keluar,
                'saldo' => rupiah($trans_bulat, 0),
            );
            $prevSaldo = $trans_bulat;
            $totalKeluar += $row->r_t_nominal_pembulatan;
        }
        if ($row->r_t_nominal_tarik_tunai != 0) {
            $keluar = rupiah($row->r_t_nominal_tarik_tunai, 0) . ", ";
            $trans_tarik = $prevSaldo - $row->r_t_nominal_tarik_tunai;
            $data[] = array(
                'tanggal' => date('d-m-Y', strtotime($row->r_t_tanggal)),
                'no nota' =>$row->r_t_nota_code,
                'transaksi' =>'Tarik Tunai',
                'masuk' => 0,
                'keluar' => $keluar,
                'saldo' => rupiah($trans_tarik, 0),
            );
            $prevSaldo = $trans_tarik;
            $totalKeluar += $row->r_t_nominal_tarik_tunai;
        }
        if ($row->r_t_nominal_free_kembalian != 0) {
            $keluar = rupiah($row->r_t_nominal_free_kembalian, 0) . ", ";
            $trans_free = $prevSaldo - $row->r_t_nominal_free_kembalian;
            $data[] = array(
                'tanggal' => date('d-m-Y', strtotime($row->r_t_tanggal)),
                'no nota' =>$row->r_t_nota_code,
                'transaksi' =>'Free Kembalian',
                'masuk' => 0,
                'keluar' => $keluar,
                'saldo' => rupiah($trans_free, 0),
            );
            $prevSaldo = $trans_free;
            $totalKeluar += $row->r_t_nominal_free_kembalian;
        }
        if ($row->r_t_nominal_kembalian != 0) {
            $keluar = rupiah($row->r_t_nominal_kembalian, 0) . ", ";
            $trans_kembali = $prevSaldo - $row->r_t_nominal_kembalian;
            $data[] = array(
                'tanggal' => date('d-m-Y', strtotime($row->r_t_tanggal)),
                'no nota' => $row->r_t_nota_code,
                'transaksi' =>'Kembalian',
                'masuk' => 0,
                'keluar' => $keluar,
                'saldo' => rupiah($trans_kembali, 0),
            );
            $prevSaldo = $trans_kembali;
            $totalKeluar += $row->r_t_nominal_kembalian;
        }
    } 
    $prevSaldoRef = 0;
    foreach ($refund as $row) {
        if ($row->r_r_nominal_refund != 0) {
            $keluar = rupiah($row->r_r_nominal_refund, 0) . ", ";
            $modal = $valModal->rekap_modal_nominal - $row->r_r_nominal_refund;
            $tnp_modal = $prevSaldoRef - $row->r_r_nominal_refund;
            $saldo = $prevSaldoRef == 0 ? $modal : $tnp_modal;
            $data[] = array(
                'tanggal' => date('d-m-Y', strtotime($row->r_t_tanggal)),
                'no nota' =>$row->r_t_nota_code,
                'transaksi' =>'Refund Nominal',
                'masuk' => 0,
                'keluar' => $keluar,
                'saldo' => rupiah($saldo, 0),
            );
            $prevSaldoRef = $saldo;
            $totalKeluar += $row->r_r_nominal_refund;
        }
        if ($row->r_r_nominal_refund_pajak != 0) {
            $keluar = rupiah($row->r_r_nominal_refund_pajak, 0) . ", ";
            $saldo = $prevSaldoRef - $row->r_r_nominal_refund_pajak;
            $data[] = array(
                'tanggal' => date('d-m-Y', strtotime($row->r_t_tanggal)),
                'no nota' =>$row->r_t_nota_code,
                'transaksi' =>'Refund Pajak',
                'masuk' => 0,
                'keluar' => $keluar,
                'saldo' => rupiah($saldo, 0),
            );
            $prevSaldoRef = $saldo;
            $totalKeluar += $row->r_r_nominal_refund_pajak;
        }
        if ($row->r_r_nominal_refund_sc != 0) {
            $keluar = rupiah($row->r_r_nominal_refund_sc, 0) . ", ";
            $saldo = $prevSaldoRef - $row->r_r_nominal_refund_sc;
            $data[] = array(
                'tanggal' => date('d-m-Y', strtotime($row->r_t_tanggal)),
                'no nota' =>$row->r_t_nota_code,
                'transaksi' =>'Refund Service Charge',
                'masuk' => 0,
                'keluar' => $keluar,
                'saldo' => rupiah($saldo, 0),
            );
            $prevSaldoRef = $saldo;
            $totalKeluar += $row->r_r_nominal_refund_sc;
        }
        if ($row->r_r_nominal_pembulatan_refund != 0) {
            $keluar = rupiah($row->r_r_nominal_pembulatan_refund, 0) . ", ";
            $saldo = $prevSaldoRef - $row->r_r_nominal_pembulatan_refund;
            $data[] = array(
                'tanggal' => date('d-m-Y', strtotime($row->r_t_tanggal)),
                'no nota' =>$row->r_t_nota_code,
                'transaksi' =>'Refund Pembulatan',
                'masuk' => 0,
                'keluar' => $keluar,
                'saldo' => rupiah($saldo, 0),
            );
            $prevSaldoRef = $saldo;
            $totalKeluar += $row->r_r_nominal_pembulatan_refund;
        }
        if ($row->r_r_nominal_free_kembalian_refund != 0) {
            $keluar = rupiah($row->r_r_nominal_free_kembalian_refund, 0) . ", ";
            $saldo = $prevSaldoRef - $row->r_r_nominal_free_kembalian_refund;
            $data[] = array(
                'tanggal' => date('d-m-Y', strtotime($row->r_t_tanggal)),
                'no nota' =>$row->r_t_nota_code,
                'transaksi' =>'Refund Free Kembalian',
                'masuk' => 0,
                'keluar' => $keluar,
                'saldo' => rupiah($saldo, 0),
            );
            $prevSaldoRef = $saldo;
            $totalKeluar += $row->r_r_nominal_free_kembalian_refund;
        }
    }
    $prevSaldoLost = 0; 
    foreach ($lostbill as $row) {
        if ($row->r_l_b_nominal != 0) {
            $keluar = rupiah($row->r_l_b_nominal, 0) . ", ";
            $modal = $valModal->rekap_modal_nominal - $row->r_l_b_nominal;
            $tnp_modal = $prevSaldoLost - $row->r_l_b_nominal;
            $saldo = $prevSaldoLost == 0 ? $modal : $tnp_modal;
            $data[] = array(
                'tanggal' => date('d-m-Y', strtotime($row->r_t_tanggal)),
                'no nota' =>$row->r_t_nota_code,
                'transaksi' =>'Lostbill Nominal',
                'masuk' => 0,
                'keluar' => $keluar,
                'saldo' => rupiah($saldo, 0),
            );
            $prevSaldoLost = $saldo;
            $totalKeluar += $row->r_l_b_nominal;
        }
        if ($row->r_l_b_nominal_pajak != 0) {
            $keluar = rupiah($row->r_l_b_nominal_pajak, 0) . ", ";
            $saldo = $prevSaldoLost - $row->r_l_b_nominal_pajak;
            $data[] = array(
                'tanggal' => date('d-m-Y', strtotime($row->r_t_tanggal)),
                'no nota' =>$row->r_t_nota_code,
                'transaksi' =>'Lostbill Pajak',
                'masuk' => 0,
                'keluar' => $keluar,
                'saldo' => rupiah($saldo, 0),
            );
            $prevSaldoLost = $saldo;
            $totalKeluar += $row->r_l_b_nominal_pajak;
        }
        if ($row->r_l_b_nominal_sc != 0) {
            $keluar = rupiah($row->r_l_b_nominal_sc, 0) . ", ";
            $saldo = $prevSaldoLost - $row->r_l_b_nominal_sc;
            $data[] = array(
                'tanggal' => date('d-m-Y', strtotime($row->r_t_tanggal)),
                'no nota' =>$row->r_t_nota_code,
                'transaksi' =>'Lostbill Service Charge',
                'masuk' => 0,
                'keluar' => $keluar,
                'saldo' => rupiah($saldo, 0),
            );
            $prevSaldoLost = $saldo;
            $totalKeluar += $row->r_l_b_nominal_sc;
        }
    }
} // saldo awal
            $saldo_terakhir = end($data)['saldo'];
            $data[] = array(
                'tanggal' => '',
                'no nota' => 'Total',
                'transaksi' => '',
                'masuk' => rupiah($totalMasuk, 0),
                'keluar' => rupiah($totalKeluar,0),
                'saldo' => $saldo_terakhir,
            );

            $output = array('data' => $data);
            return response()->json($output);
       
        return response()->json($output);
    }

     public function show(Request $request)
     {
         [$start, $end] = explode('to' ,$request->tanggal);
         [$opr, $sesi] = explode('and' ,$request->operator);

        $saldoIn = DB::table('rekap_modal')
                    ->where('rekap_modal_m_w_code', $request->waroeng)
                    ->where('rekap_modal_created_by', $opr)
                    ->where('rekap_modal_sesi', $sesi)
                    ->whereBetween('rekap_modal_tanggal', [$start, $end])
                    ->where('rekap_modal_status', 'close')
                    ->orderBy('rekap_modal_tanggal', 'ASC')
                    ->get();
 
             $data = array();
             foreach ($saldoIn as $key => $val_in) {
                        $row = array();
                        $row[] = date('d-m-Y', strtotime($val_in->rekap_modal_tanggal));
                        $row[] = rupiah($val_in->rekap_modal_nominal, 0);
                        $row[] = rupiah($val_in->rekap_modal_cash_in, 0);
                        $row[] = rupiah($val_in->rekap_modal_cash_out, 0);
                            $saldoAkhir = $val_in->rekap_modal_nominal + $val_in->rekap_modal_cash_in - $val_in->rekap_modal_cash_out;
                        $row[] = rupiah($saldoAkhir, 0);
                        $row[] = rupiah($val_in->rekap_modal_cash_real, 0);
                        $row[] = rupiah($val_in->rekap_modal_cash_real - $saldoAkhir, 0);
                        $row[] ='<a id="button_detail" class="btn btn-sm button_detail btn-info" value="'.$val_in->rekap_modal_id.'" title="Detail Nota"><i class="fa-sharp fa-solid fa-file"></i></a>';
                        $data[] = $row;
                }
 
         $output = array("data" => $data);
         return response()->json($output);
     }
 
}

// $data = array();
//             $total_masuk = 0;
//             $total_keluar = 0;
//             $saldo_akhir = 0;
            
//             foreach ($modal as $valModal) {
//                 $saldo_akhir = $valModal->rekap_modal_nominal;
                
//                 $data[] = array(
//                     'tanggal' => date('d-m-Y', strtotime($valModal->rekap_modal_tanggal)),
//                     'transaksi' => 'Modal awal',
//                     'masuk' => 0,
//                     'keluar' => 0,
//                     'saldo' => rupiah($saldo_akhir, 0),
//                 );
//             }
            
//             foreach ($mutasi as $row) {
//                 $masuk = ($row->r_m_m_kredit != null) ? $row->r_m_m_kredit : 0;
//                 $keluar = ($row->r_m_m_debit != null) ? $row->r_m_m_debit : 0;
//                 $saldo_akhir = $saldo_akhir + $masuk - $keluar;
                
//                 $data[] = array(
//                     'tanggal' => date('d-m-Y', strtotime($row->r_m_m_tanggal)),
//                     'transaksi' => $row->r_m_m_keterangan,
//                     'masuk' => rupiah($masuk, 0),
//                     'keluar' => rupiah($keluar, 0),
//                     'saldo' => rupiah($saldo_akhir, 0),
//                 );
                
//                 $total_masuk += $masuk;
//                 $total_keluar += $keluar;
//             }
            
//             foreach ($transaksi as $row) {
//                 $masuk = ($row->r_t_m_t_t_id == '1') ? $row->r_t_nominal_total_bayar : 0;
//                 $keluar = $row->r_t_nominal_pembulatan + $row->r_t_nominal_tarik_tunai + $row->r_t_nominal_free_kembalian + $row->r_t_nominal_kembalian;
//                 $saldo_akhir = $saldo_akhir - $keluar + $masuk;
                
//                 $data[] = array(
//                     'tanggal' => date('d-m-Y', strtotime($row->r_t_tanggal)),
//                     'transaksi' =>'Pembayaran a/n '.$row->r_t_bigboss,
//                     'masuk' => rupiah($masuk, 0),
//                     'keluar' => rupiah($keluar, 0),
//                     'saldo' => rupiah($saldo_akhir, 0),
//                 );
                
//                 $total_masuk += $masuk;
//                 $total_keluar += $keluar;
//             }
            
//             foreach ($refund as $row) {
//                 $keluar = $row->r_r_nominal_refund_total;
//                 $saldo_akhir = $saldo_akhir - $keluar;
                
//                 $data[] = array(
//                     'tanggal' => date('d-m-Y', strtotime($row->r_r_tanggal)),
//                     'transaksi' => 'Refund',
//                     'masuk' => 0,
//                     'keluar' => rupiah($keluar, 0),
//                     'saldo' => rupiah($saldo_akhir, 0),
//                 );
                
//                 $total_keluar += $keluar;
//             }
//             $output = array(
//                 'data' => $data,
//                 'total_masuk' => rupiah($total_masuk, 0),
//                 'total_keluar' => rupiah($total_keluar, 0),
//                 'saldo_akhir' => rupiah($saldo_akhir, 0),
//             );
       
//         return response()->json($output);