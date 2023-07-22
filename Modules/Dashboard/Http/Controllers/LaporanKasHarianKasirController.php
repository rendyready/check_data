<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanKasHarianKasirController extends Controller
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
            $data[$val->m_w_id] = [$val->m_w_nama];
            //  $data['all'] = ['all waroeng'];
        }
        return response()->json($data);
    }

    public function detail($id)
    {
        $data = DB::table('rekap_modal')
            ->join('users', 'users_id', 'rekap_modal_created_by')
            ->where('rekap_modal_id', $id)
            ->first();

        return response()->json($data);
    }

    public function export_pdf(Request $request)
    {
        $modal = DB::table('rekap_modal')
            ->where('rekap_modal_m_w_id', $request->waroeng)
            ->where('rekap_modal_id', $request->id)
            ->where('rekap_modal_status', 'close')
            ->orderby('rekap_modal_tanggal', 'ASC')
            ->get();
        $mutasi = DB::table('rekap_mutasi_modal')
            ->where('r_m_m_m_w_id', $request->waroeng)
            ->where('r_m_m_rekap_modal_id', $request->id)
            ->orderby('r_m_m_tanggal', 'ASC')
            ->orderby('r_m_m_jam', 'ASC')
            ->get();
        $transaksi = DB::table('rekap_transaksi')
            ->join('rekap_payment_transaksi', 'r_p_t_r_t_id', 'r_t_id')
            ->where('r_t_m_w_id', $request->waroeng)
            ->where('r_t_rekap_modal_id', $request->id)
            ->where('r_p_t_m_payment_method_id', 1)
            ->orderby('r_t_tanggal', 'ASC')
            ->orderby('r_t_jam', 'ASC')
            ->get();
        $transaksi2 = DB::table('rekap_transaksi')
            ->join('rekap_payment_transaksi', 'r_p_t_r_t_id', 'r_t_id')
            ->where('r_t_m_w_id', $request->waroeng)
            ->where('r_t_rekap_modal_id', $request->id)
            ->whereIn('r_p_t_m_payment_method_id', [2, 3, 4, 5, 6, 7, 8, 9])
            ->orderby('r_t_tanggal', 'ASC')
            ->orderby('r_t_jam', 'ASC')
            ->get();
        $refund = DB::table('rekap_refund')
            ->where('r_r_m_w_id', $request->waroeng)
            ->where('r_r_rekap_modal_id', $request->id)
            ->orderby('r_r_tanggal', 'ASC')
            ->orderby('r_r_jam', 'ASC')
            ->get();

        //Tunai
        $data = array();
        foreach ($modal as $valModal) {
            $data[] = array(
                'no_nota' => $valModal->rekap_modal_id,
                'transaksi' => 'Modal awal',
                'masuk' => 0,
                'keluar' => 0,
                'saldo' => rupiah($valModal->rekap_modal_nominal, 0),
                'payment' => 1,
            );
            $totalKeluar = 0;
            $totalMasuk = 0;
            $prevSaldoMut = 0;
            $saldoAkhir = $valModal->rekap_modal_nominal + $valModal->rekap_modal_cash_in - $valModal->rekap_modal_cash_out;
            $data[] = array(
                'no_nota' => number_format($valModal->rekap_modal_nominal),
                'transaksi' => number_format($valModal->rekap_modal_cash_in),
                'masuk' => number_format($valModal->rekap_modal_cash_out),
                'keluar' => number_format($saldoAkhir),
                'saldo' => number_format($valModal->rekap_modal_cash_real - $saldoAkhir),
                'payment' => 22,
            );
            foreach ($mutasi as $row) {
                if ($row->r_m_m_debit != 0) {
                    $masuk = $row->r_m_m_debit;
                    $modal = $valModal->rekap_modal_nominal - $row->r_m_m_debit;
                    $tnp_modal = $prevSaldoMut - $row->r_m_m_debit;
                    $saldo = $prevSaldoMut == 0 ? $modal : $tnp_modal;
                    $data[] = array(
                        'no_nota' => $row->r_m_m_id,
                        'transaksi' => $row->r_m_m_keterangan,
                        'masuk' => rupiah($masuk, 0),
                        'keluar' => 0,
                        'saldo' => rupiah($saldo, 0),
                        'payment' => 1,
                    );
                    $totalMasuk += $row->r_m_m_debit;
                    $prevSaldoMut = $saldo;
                }
                if ($row->r_m_m_kredit != 0) {
                    $keluar = $row->r_m_m_kredit;
                    $saldo = $prevSaldoMut + $row->r_m_m_kredit;
                    $data[] = array(
                        'no_nota' => $row->r_m_m_id,
                        'transaksi' => $row->r_m_m_keterangan,
                        'masuk' => 0,
                        'keluar' => rupiah($keluar, 0),
                        'saldo' => rupiah($saldo, 0),
                        'payment' => 1,
                    );
                    $totalKeluar += $row->r_m_m_kredit;
                    $prevSaldoMut = $saldo;
                }
            }
            $prevSaldo = 0;
            foreach ($transaksi as $row) {
                if ($row->r_t_nominal != 0) {
                    $masuk = rupiah($row->r_t_nominal, 0);
                    $trans_nom_mdl = $valModal->rekap_modal_nominal + $row->r_t_nominal;
                    $trans_nom = $prevSaldo + $row->r_t_nominal;
                    $saldo = $prevSaldo == 0 ? $trans_nom_mdl : $trans_nom;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Transaksi',
                        'masuk' => $masuk,
                        'keluar' => 0,
                        'saldo' => rupiah($saldo, 0),
                        'payment' => 1,
                    );
                    $prevSaldo = $saldo;
                    $totalMasuk += $row->r_t_nominal;
                }
                if ($row->r_t_nominal_pajak != 0) {
                    $masuk = rupiah($row->r_t_nominal_pajak, 0);
                    $trans_pajak = $prevSaldo + $row->r_t_nominal_pajak;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Pajak',
                        'masuk' => $masuk,
                        'keluar' => 0,
                        'saldo' => rupiah($trans_pajak, 0),
                        'payment' => 1,
                    );
                    $prevSaldo = $trans_pajak;
                    $totalMasuk += $row->r_t_nominal_pajak;
                }
                if ($row->r_t_nominal_sc != 0) {
                    $masuk = rupiah($row->r_t_nominal_sc, 0);
                    $trans_sc = $prevSaldo + $row->r_t_nominal_sc;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Servis Charge',
                        'masuk' => $masuk,
                        'keluar' => 0,
                        'saldo' => rupiah($trans_sc, 0),
                        'payment' => 1,
                    );
                    $prevSaldo = $trans_sc;
                    $totalMasuk += $row->r_t_nominal_sc;
                }
                if ($row->r_t_nominal_diskon != 0) {
                    $masuk = rupiah($row->r_t_nominal_diskon, 0);
                    $trans_diskon = $prevSaldo + $row->r_t_nominal_diskon;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Voucher',
                        'masuk' => $masuk,
                        'keluar' => 0,
                        'saldo' => rupiah($trans_diskon, 0),
                        'payment' => 1,
                    );
                    $prevSaldo = $trans_diskon;
                    $totalMasuk += $row->r_t_nominal_diskon;
                }
                if ($row->r_t_nominal_voucher != 0) {
                    $masuk = rupiah($row->r_t_nominal_voucher, 0);
                    $trans_voucer = $prevSaldo + $row->r_t_nominal_voucher;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Voucher',
                        'masuk' => $masuk,
                        'keluar' => 0,
                        'saldo' => rupiah($trans_voucer, 0),
                        'payment' => 1,
                    );
                    $prevSaldo = $trans_voucer;
                    $totalMasuk += $row->r_t_nominal_voucher;
                }
                if ($row->r_t_nominal_pembulatan != 0) {
                    $keluar = rupiah($row->r_t_nominal_pembulatan, 0);
                    $trans_bulat = $prevSaldo - $row->r_t_nominal_pembulatan;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Pembualatan',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => rupiah($trans_bulat, 0),
                        'payment' => 1,
                    );
                    $prevSaldo = $trans_bulat;
                    $totalKeluar += $row->r_t_nominal_pembulatan;
                }
                if ($row->r_t_nominal_tarik_tunai != 0) {
                    $keluar = rupiah($row->r_t_nominal_tarik_tunai, 0);
                    $trans_tarik = $prevSaldo - $row->r_t_nominal_tarik_tunai;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Tarik Tunai',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => rupiah($trans_tarik, 0),
                        'payment' => 1,
                    );
                    $prevSaldo = $trans_tarik;
                    $totalKeluar += $row->r_t_nominal_tarik_tunai;
                }
                if ($row->r_t_nominal_free_kembalian != 0) {
                    $keluar = rupiah($row->r_t_nominal_free_kembalian, 0);
                    $trans_free = $prevSaldo - $row->r_t_nominal_free_kembalian;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Free Kembalian',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => rupiah($trans_free, 0),
                        'payment' => 1,
                    );
                    $prevSaldo = $trans_free;
                    $totalKeluar += $row->r_t_nominal_free_kembalian;
                }
            }
            $prevSaldoRef = 0;
            foreach ($refund as $row) {
                if ($row->r_r_nominal_refund != 0) {
                    $keluar = rupiah($row->r_r_nominal_refund, 0);
                    $modal = $valModal->rekap_modal_nominal - $row->r_r_nominal_refund;
                    $tnp_modal = $prevSaldoRef - $row->r_r_nominal_refund;
                    $saldo = $prevSaldoRef == 0 ? $modal : $tnp_modal;
                    $data[] = array(
                        'no_nota' => $row->r_r_nota_code,
                        'transaksi' => 'Refund Nominal',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => rupiah($saldo, 0),
                        'payment' => 1,
                    );
                    $prevSaldoRef = $saldo;
                    $totalKeluar += $row->r_r_nominal_refund;
                }
                if ($row->r_r_nominal_refund_pajak != 0) {
                    $keluar = rupiah($row->r_r_nominal_refund_pajak, 0);
                    $saldo = $prevSaldoRef - $row->r_r_nominal_refund_pajak;
                    $data[] = array(
                        'no_nota' => $row->r_r_nota_code,
                        'transaksi' => 'Refund Pajak',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => rupiah($saldo, 0),
                        'payment' => 1,
                    );
                    $prevSaldoRef = $saldo;
                    $totalKeluar += $row->r_r_nominal_refund_pajak;
                }
                if ($row->r_r_nominal_refund_sc != 0) {
                    $keluar = rupiah($row->r_r_nominal_refund_sc, 0);
                    $saldo = $prevSaldoRef - $row->r_r_nominal_refund_sc;
                    $data[] = array(
                        'no_nota' => $row->r_r_nota_code,
                        'transaksi' => 'Refund Service Charge',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => rupiah($saldo, 0),
                        'payment' => 1,
                    );
                    $prevSaldoRef = $saldo;
                    $totalKeluar += $row->r_r_nominal_refund_sc;
                }
                if ($row->r_r_nominal_pembulatan_refund != 0) {
                    $keluar = rupiah($row->r_r_nominal_pembulatan_refund, 0);
                    $saldo = $prevSaldoRef - $row->r_r_nominal_pembulatan_refund;
                    $data[] = array(
                        'no_nota' => $row->r_r_nota_code,
                        'transaksi' => 'Refund Pembulatan',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => rupiah($saldo, 0),
                        'payment' => 1,
                    );
                    $prevSaldoRef = $saldo;
                    $totalKeluar += $row->r_r_nominal_pembulatan_refund;
                }
                if ($row->r_r_nominal_free_kembalian_refund != 0) {
                    $keluar = rupiah($row->r_r_nominal_free_kembalian_refund, 0);
                    $saldo = $prevSaldoRef - $row->r_r_nominal_free_kembalian_refund;
                    $data[] = array(
                        'no_nota' => $row->r_r_nota_code,
                        'transaksi' => 'Refund Free Kembalian',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => rupiah($saldo, 0),
                        'payment' => 1,
                    );
                    $prevSaldoRef = $saldo;
                    $totalKeluar += $row->r_r_nominal_free_kembalian_refund;
                }
            }
        } // saldo awal
        $saldo_terakhir = end($data)['saldo'];
        $data[] = array(
            'no_nota' => 'Total',
            'transaksi' => '',
            'masuk' => rupiah($totalMasuk, 0),
            'keluar' => rupiah($totalKeluar, 0),
            'saldo' => $saldo_terakhir,
            'payment' => 1,
        );

        //Non Tunai
        $totalKeluar = 0;
        $totalMasuk = 0;
        $prevSaldo = 0;
        foreach ($transaksi2 as $row) {
            if ($row->r_t_nominal != 0) {
                $masuk = rupiah($row->r_t_nominal, 0);
                // $trans_nom_mdl = $valModal->rekap_modal_nominal + $row->r_t_nominal;
                $saldo = $prevSaldo + $row->r_t_nominal;
                // $saldo = $prevSaldo == 0 ? $trans_nom_mdl : $trans_nom;
                $data[] = array(
                    'no_nota' => $row->r_t_nota_code,
                    'transaksi' => 'Transaksi',
                    'masuk' => $masuk,
                    'keluar' => 0,
                    'saldo' => rupiah($saldo, 0),
                    'payment' => 2, 3, 4, 5, 6, 7, 8, 9,
                );
                $prevSaldo = $saldo;
                $totalMasuk += $row->r_t_nominal;
            }
            if ($row->r_t_nominal_pajak != 0) {
                $masuk = rupiah($row->r_t_nominal_pajak, 0);
                $trans_pajak = $prevSaldo + $row->r_t_nominal_pajak;
                $data[] = array(
                    'no_nota' => $row->r_t_nota_code,
                    'transaksi' => 'Pajak',
                    'masuk' => $masuk,
                    'keluar' => 0,
                    'saldo' => rupiah($trans_pajak, 0),
                    'payment' => 2, 3, 4, 5, 6, 7, 8, 9,
                );
                $prevSaldo = $trans_pajak;
                $totalMasuk += $row->r_t_nominal_pajak;
            }
            if ($row->r_t_nominal_sc != 0) {
                $masuk = rupiah($row->r_t_nominal_sc, 0);
                $trans_sc = $prevSaldo + $row->r_t_nominal_sc;
                $data[] = array(
                    'no_nota' => $row->r_t_nota_code,
                    'transaksi' => 'Servis Charge',
                    'masuk' => $masuk,
                    'keluar' => 0,
                    'saldo' => rupiah($trans_sc, 0),
                    'payment' => 2, 3, 4, 5, 6, 7, 8, 9,
                );
                $prevSaldo = $trans_sc;
                $totalMasuk += $row->r_t_nominal_sc;
            }
            if ($row->r_t_nominal_diskon != 0) {
                $masuk = rupiah($row->r_t_nominal_diskon, 0);
                $trans_diskon = $prevSaldo + $row->r_t_nominal_diskon;
                $data[] = array(
                    'no_nota' => $row->r_t_nota_code,
                    'transaksi' => 'Voucher',
                    'masuk' => $masuk,
                    'keluar' => 0,
                    'saldo' => rupiah($trans_diskon, 0),
                    'payment' => 2, 3, 4, 5, 6, 7, 8, 9,
                );
                $prevSaldo = $trans_diskon;
                $totalMasuk += $row->r_t_nominal_diskon;
            }
            if ($row->r_t_nominal_voucher != 0) {
                $masuk = rupiah($row->r_t_nominal_voucher, 0);
                $trans_voucer = $prevSaldo + $row->r_t_nominal_voucher;
                $data[] = array(
                    'no_nota' => $row->r_t_nota_code,
                    'transaksi' => 'Voucher',
                    'masuk' => $masuk,
                    'keluar' => 0,
                    'saldo' => rupiah($trans_voucer, 0),
                    'payment' => 2, 3, 4, 5, 6, 7, 8, 9,
                );
                $prevSaldo = $trans_voucer;
                $totalMasuk += $row->r_t_nominal_voucher;
            }
            if ($row->r_t_nominal_pembulatan != 0) {
                $keluar = rupiah($row->r_t_nominal_pembulatan, 0);
                $trans_bulat = $prevSaldo - $row->r_t_nominal_pembulatan;
                $data[] = array(
                    'no_nota' => $row->r_t_nota_code,
                    'transaksi' => 'Pembualatan',
                    'masuk' => 0,
                    'keluar' => $keluar,
                    'saldo' => rupiah($trans_bulat, 0),
                    'payment' => 2, 3, 4, 5, 6, 7, 8, 9,
                );
                $prevSaldo = $trans_bulat;
                $totalKeluar += $row->r_t_nominal_pembulatan;
            }
            if ($row->r_t_nominal_tarik_tunai != 0) {
                $keluar = rupiah($row->r_t_nominal_tarik_tunai, 0);
                $trans_tarik = $prevSaldo - $row->r_t_nominal_tarik_tunai;
                $data[] = array(
                    'no_nota' => $row->r_t_nota_code,
                    'transaksi' => 'Tarik Tunai',
                    'masuk' => 0,
                    'keluar' => $keluar,
                    'saldo' => rupiah($trans_tarik, 0),
                    'payment' => 2, 3, 4, 5, 6, 7, 8, 9,
                );
                $prevSaldo = $trans_tarik;
                $totalKeluar += $row->r_t_nominal_tarik_tunai;
            }
            if ($row->r_t_nominal_free_kembalian != 0) {
                $keluar = rupiah($row->r_t_nominal_free_kembalian, 0);
                $trans_free = $prevSaldo - $row->r_t_nominal_free_kembalian;
                $data[] = array(
                    'no_nota' => $row->r_t_nota_code,
                    'transaksi' => 'Free Kembalian',
                    'masuk' => 0,
                    'keluar' => $keluar,
                    'saldo' => rupiah($trans_free, 0),
                    'payment' => 2, 3, 4, 5, 6, 7, 8, 9,
                );
                $prevSaldo = $trans_free;
                $totalKeluar += $row->r_t_nominal_free_kembalian;
            }
        } // saldo awal
        $saldo_terakhir = end($data)['saldo'];
        $data[] = array(
            'no_nota' => 'Total',
            'transaksi' => '',
            'masuk' => rupiah($totalMasuk, 0),
            'keluar' => rupiah($totalKeluar, 0),
            'saldo' => $saldo_terakhir,
            'payment' => 2, 3, 4, 5, 6, 7, 8, 9,
        );

        $tgl = tgl_indo($request->tanggal);
        $w_nama = strtoupper($this->getNamaW($request->waroeng));
        // $nama_user = DB::table('users')->where('users_id',$request->opr)->get()->name();
        // $kacab = DB::table('history_jabatan')
        // ->where('history_jabatan_m_w_code',$request->waroeng)
        // ->first();
        $nama_kasir = DB::table('users')
            ->join('rekap_modal', 'rekap_modal_created_by', 'users_id')
            ->where('waroeng_id', $request->waroeng)
            ->where('rekap_modal_id', $request->id)
            ->first();
        $sesi_kasir = DB::table('rekap_modal')
            ->where('rekap_modal_m_w_id', $request->waroeng)
            ->where('rekap_modal_id', $request->id)
            ->first();
        $kasir = $nama_kasir->name;
        $shift = $sesi_kasir->rekap_modal_sesi;

        // $id2 = [2,3,4,5,6,7];
        //    return view('dashboard::lap_kas_harian_kasir_pdf',compact('data','tgl','w_nama','kacab','kasir','shift'));
        $pdf = pdf::loadview('dashboard::lap_kas_harian_kasir_pdf', compact('data', 'tgl', 'w_nama', 'kasir', 'shift'))->setPaper('a4');
        return $pdf->download('laporan_kas_kasir_' . strtolower($w_nama) . '_sesi_' . $shift . '_.pdf');
    }

    public function detail_show(Request $request, $id)
    {
        $modal = DB::table('rekap_modal')
            ->where('rekap_modal_m_w_id', $request->waroeng)
            ->where('rekap_modal_id', $id)
            ->orderby('rekap_modal_tanggal', 'ASC')
            ->get();
        $mutasi = DB::table('rekap_mutasi_modal')
            ->where('r_m_m_m_w_id', $request->waroeng)
            ->where('r_m_m_rekap_modal_id', $id)
            ->orderby('r_m_m_tanggal', 'ASC')
            ->orderby('r_m_m_jam', 'ASC')
            ->get();
        $transaksi = DB::table('rekap_transaksi')
            ->join('rekap_payment_transaksi', 'r_p_t_r_t_id', 'r_t_id')
            ->where('r_t_m_w_id', $request->waroeng)
            ->where('r_t_rekap_modal_id', $id)
            ->where('r_p_t_m_payment_method_id', '1')
            ->orderby('r_t_tanggal', 'ASC')
            ->orderby('r_t_jam', 'ASC')
            ->get();
        $refund = DB::table('rekap_refund')
            ->where('r_r_m_w_id', $request->waroeng)
            ->where('r_r_rekap_modal_id', $id)
            ->orderby('r_r_tanggal', 'ASC')
            ->orderby('r_r_jam', 'ASC')
            ->get();

        $data = array();
        foreach ($modal as $valModal) {
            $data[] = array(
                'no_nota' => $valModal->rekap_modal_id,
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
                    $masuk = $row->r_m_m_debit;
                    $modal = $valModal->rekap_modal_nominal - $row->r_m_m_debit;
                    $tnp_modal = $prevSaldoMut - $row->r_m_m_debit;
                    $saldo = $prevSaldoMut == 0 ? $modal : $tnp_modal;
                    $data[] = array(
                        'no_nota' => $row->r_m_m_id,
                        'transaksi' => $row->r_m_m_keterangan,
                        'masuk' => rupiah($masuk, 0),
                        'keluar' => 0,
                        'saldo' => rupiah($saldo, 0),
                    );
                    $totalMasuk += $row->r_m_m_debit;
                    $prevSaldoMut = $saldo;
                }
                if ($row->r_m_m_kredit != 0) {
                    $keluar = $row->r_m_m_kredit;
                    $saldo = $prevSaldoMut + $row->r_m_m_kredit;
                    $data[] = array(
                        'no_nota' => $row->r_m_m_id,
                        'transaksi' => $row->r_m_m_keterangan,
                        'masuk' => 0,
                        'keluar' => rupiah($keluar, 0),
                        'saldo' => rupiah($saldo, 0),
                    );
                    $totalKeluar += $row->r_m_m_kredit;
                    $prevSaldoMut = $saldo;
                }
            }
            $prevSaldo = 0;
            foreach ($transaksi as $row) {
                if ($row->r_t_nominal != 0) {
                    $masuk = rupiah($row->r_t_nominal, 0);
                    $trans_nom_mdl = $valModal->rekap_modal_nominal + $row->r_t_nominal;
                    $trans_nom = $prevSaldo + $row->r_t_nominal;
                    $saldo = $prevSaldo == 0 ? $trans_nom_mdl : $trans_nom;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Transaksi',
                        'masuk' => $masuk,
                        'keluar' => 0,
                        'saldo' => rupiah($saldo, 0),
                    );
                    $prevSaldo = $saldo;
                    $totalMasuk += $row->r_t_nominal;
                }
                if ($row->r_t_nominal_pajak != 0) {
                    $masuk = rupiah($row->r_t_nominal_pajak, 0);
                    $trans_pajak = $prevSaldo + $row->r_t_nominal_pajak;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Pajak',
                        'masuk' => $masuk,
                        'keluar' => 0,
                        'saldo' => rupiah($trans_pajak, 0),
                    );
                    $prevSaldo = $trans_pajak;
                    $totalMasuk += $row->r_t_nominal_pajak;
                }
                if ($row->r_t_nominal_sc != 0) {
                    $masuk = rupiah($row->r_t_nominal_sc, 0);
                    $trans_sc = $prevSaldo + $row->r_t_nominal_sc;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Servis Charge',
                        'masuk' => $masuk,
                        'keluar' => 0,
                        'saldo' => rupiah($trans_sc, 0),
                    );
                    $prevSaldo = $trans_sc;
                    $totalMasuk += $row->r_t_nominal_sc;
                }
                if ($row->r_t_nominal_diskon != 0) {
                    $masuk = rupiah($row->r_t_nominal_diskon, 0);
                    $trans_diskon = $prevSaldo + $row->r_t_nominal_diskon;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Voucher',
                        'masuk' => $masuk,
                        'keluar' => 0,
                        'saldo' => rupiah($trans_diskon, 0),
                    );
                    $prevSaldo = $trans_diskon;
                    $totalMasuk += $row->r_t_nominal_diskon;
                }
                if ($row->r_t_nominal_voucher != 0) {
                    $masuk = rupiah($row->r_t_nominal_voucher, 0);
                    $trans_voucer = $prevSaldo + $row->r_t_nominal_voucher;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Voucher',
                        'masuk' => $masuk,
                        'keluar' => 0,
                        'saldo' => rupiah($trans_voucer, 0),
                    );
                    $prevSaldo = $trans_voucer;
                    $totalMasuk += $row->r_t_nominal_voucher;
                }
                if ($row->r_t_nominal_pembulatan != 0) {
                    $keluar = rupiah($row->r_t_nominal_pembulatan, 0);
                    $trans_bulat = $prevSaldo - $row->r_t_nominal_pembulatan;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Pembualatan',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => rupiah($trans_bulat, 0),
                    );
                    $prevSaldo = $trans_bulat;
                    $totalKeluar += $row->r_t_nominal_pembulatan;
                }
                if ($row->r_t_nominal_tarik_tunai != 0) {
                    $keluar = rupiah($row->r_t_nominal_tarik_tunai, 0);
                    $trans_tarik = $prevSaldo - $row->r_t_nominal_tarik_tunai;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Tarik Tunai',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => rupiah($trans_tarik, 0),
                    );
                    $prevSaldo = $trans_tarik;
                    $totalKeluar += $row->r_t_nominal_tarik_tunai;
                }
                if ($row->r_t_nominal_free_kembalian != 0) {
                    $keluar = rupiah($row->r_t_nominal_free_kembalian, 0);
                    $trans_free = $prevSaldo - $row->r_t_nominal_free_kembalian;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Free Kembalian',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => rupiah($trans_free, 0),
                    );
                    $prevSaldo = $trans_free;
                    $totalKeluar += $row->r_t_nominal_free_kembalian;
                }
            }
            $prevSaldoRef = 0;
            foreach ($refund as $row) {
                if ($row->r_r_nominal_refund != 0) {
                    $keluar = rupiah($row->r_r_nominal_refund, 0);
                    $modal = $valModal->rekap_modal_nominal - $row->r_r_nominal_refund;
                    $tnp_modal = $prevSaldoRef - $row->r_r_nominal_refund;
                    $saldo = $prevSaldoRef == 0 ? $modal : $tnp_modal;
                    $data[] = array(
                        'no_nota' => $row->r_r_nota_code,
                        'transaksi' => 'Refund Nominal',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => rupiah($saldo, 0),
                    );
                    $prevSaldoRef = $saldo;
                    $totalKeluar += $row->r_r_nominal_refund;
                }
                if ($row->r_r_nominal_refund_pajak != 0) {
                    $keluar = rupiah($row->r_r_nominal_refund_pajak, 0);
                    $saldo = $prevSaldoRef - $row->r_r_nominal_refund_pajak;
                    $data[] = array(
                        'no_nota' => $row->r_r_nota_code,
                        'transaksi' => 'Refund Pajak',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => rupiah($saldo, 0),
                    );
                    $prevSaldoRef = $saldo;
                    $totalKeluar += $row->r_r_nominal_refund_pajak;
                }
                if ($row->r_r_nominal_refund_sc != 0) {
                    $keluar = rupiah($row->r_r_nominal_refund_sc, 0);
                    $saldo = $prevSaldoRef - $row->r_r_nominal_refund_sc;
                    $data[] = array(
                        'no_nota' => $row->r_r_nota_code,
                        'transaksi' => 'Refund Service Charge',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => rupiah($saldo, 0),
                    );
                    $prevSaldoRef = $saldo;
                    $totalKeluar += $row->r_r_nominal_refund_sc;
                }
                if ($row->r_r_nominal_pembulatan_refund != 0) {
                    $keluar = rupiah($row->r_r_nominal_pembulatan_refund, 0);
                    $saldo = $prevSaldoRef - $row->r_r_nominal_pembulatan_refund;
                    $data[] = array(
                        'no_nota' => $row->r_r_nota_code,
                        'transaksi' => 'Refund Pembulatan',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => rupiah($saldo, 0),
                    );
                    $prevSaldoRef = $saldo;
                    $totalKeluar += $row->r_r_nominal_pembulatan_refund;
                }
                if ($row->r_r_nominal_free_kembalian_refund != 0) {
                    $keluar = rupiah($row->r_r_nominal_free_kembalian_refund, 0);
                    $saldo = $prevSaldoRef - $row->r_r_nominal_free_kembalian_refund;
                    $data[] = array(
                        'no_nota' => $row->r_r_nota_code,
                        'transaksi' => 'Refund Free Kembalian',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => rupiah($saldo, 0),
                    );
                    $prevSaldoRef = $saldo;
                    $totalKeluar += $row->r_r_nominal_free_kembalian_refund;
                }
            }
        } // saldo awal
        $saldo_terakhir = end($data)['saldo'];
        $data[] = array(
            'no_nota' => '',
            'transaksi' => 'Total',
            'masuk' => rupiah($totalMasuk, 0),
            'keluar' => rupiah($totalKeluar, 0),
            'saldo' => $saldo_terakhir,
        );

        $output = array('data' => $data);
        return response()->json($output);
    }

    public function show(Request $request)
    {
        $saldoIn = DB::table('rekap_modal')
            ->join('users', 'users_id', 'rekap_modal_created_by')
            ->join('rekap_transaksi', 'r_t_rekap_modal_id', 'rekap_modal_id')
            ->selectRaw('rekap_modal_id, rekap_modal_tanggal, rekap_modal_sesi, name, max(rekap_modal_nominal) rekap_modal_nominal, max(rekap_modal_cash_in) rekap_modal_cash_in, max(rekap_modal_cash_out) rekap_modal_cash_out, max(rekap_modal_cash_real) rekap_modal_cash_real, sum(r_t_nominal_free_kembalian) free, sum(r_t_nominal_pembulatan) bulat')
            ->where('rekap_modal_status', 'close')
            ->where('rekap_modal_m_area_id', $request->area)
            ->where('rekap_modal_m_w_id', $request->waroeng);
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $saldoIn->whereBetween(DB::raw('DATE(rekap_modal_tanggal)'), [$start, $end]);
        } else {
            $saldoIn->where(DB::raw('DATE(rekap_modal_tanggal)'), $request->tanggal);
        }
        // if (!in_array(Auth::user()->waroeng_id, $this->get_akses_area())) {
        //     $saldoIn->where('rekap_modal_status', 'close');
        // }
        $saldoIn1 = $saldoIn->groupby('rekap_modal_id', 'rekap_modal_tanggal', 'rekap_modal_sesi', 'name')
            ->orderBy('rekap_modal_tanggal', 'ASC')
            ->get();

        $totalSelisih = 0;
        $totalFreeKembalian = 0;
        $totalPembulatan = 0;
        $data = array();
        foreach ($saldoIn1 as $key => $val_in) {
            $row = array();
            $row[] = date('d-m-Y H:i', strtotime($val_in->rekap_modal_tanggal));
            $row[] = $val_in->rekap_modal_sesi;
            $row[] = $val_in->name;
            $row[] = number_format($val_in->rekap_modal_nominal);
            $row[] = number_format($val_in->rekap_modal_cash_in);
            $row[] = number_format($val_in->rekap_modal_cash_out);
            $saldoAkhir = $val_in->rekap_modal_nominal + $val_in->rekap_modal_cash_in - $val_in->rekap_modal_cash_out;
            $row[] = number_format($saldoAkhir);
            $row[] = number_format($val_in->rekap_modal_cash_real);
            $row[] = number_format($val_in->rekap_modal_cash_real - $saldoAkhir);
            $row[] = number_format($val_in->free);
            $row[] = number_format($val_in->bulat);
            $row[] = '<a id="button_detail" class="btn btn-sm button_detail btn-info" value="' . $val_in->rekap_modal_id . '" title="Detail Nota"><i class="fa-sharp fa-solid fa-eye"></i></a>
                        <a id="button_pdf" value="' . $val_in->rekap_modal_id . '" class="btn btn-sm btn-warning" title="Export PDF"><i class="fa-sharp fa-solid fa-file"></i></a>
                        <a id="button_tarikan" value="' . $val_in->rekap_modal_id . '" class="btn btn-sm btn-success" title="Lihat Tarikan"><i class="fa-sharp fa-solid fa-print"></i></a>';
            $data[] = $row;

            $totalSelisih += $val_in->rekap_modal_cash_real - $saldoAkhir;
            $totalFreeKembalian += $val_in->free;
            $totalPembulatan += $val_in->bulat;
        }
        $totalRow = array();
        $totalRow[] = '';
        $totalRow[] = '';
        $totalRow[] = '';
        $totalRow[] = '';
        $totalRow[] = '';
        $totalRow[] = '';
        $totalRow[] = '';
        $totalRow[] = 'Total';
        $totalRow[] = number_format($totalSelisih);
        $totalRow[] = number_format($totalFreeKembalian);
        $totalRow[] = number_format($totalPembulatan);
        $totalRow[] = '';

        $data[] = $totalRow;

        $output = array("data" => $data);
        return response()->json($output);
    }

}
