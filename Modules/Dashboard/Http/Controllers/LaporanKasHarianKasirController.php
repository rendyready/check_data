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
        if ($request->id_area != 'all') {
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
                'saldo' => number_format($valModal->rekap_modal_nominal),
                'payment' => 1,
            );
            $totalKeluar = 0;
            $totalMasuk = 0;
            $pembulatan = 0;
            $diskon = 0;
            $voucher = 0;
            $prevSaldo = $valModal->rekap_modal_nominal;
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
                    $modal = $valModal->rekap_modal_nominal + $row->r_m_m_debit;
                    $tnp_modal = $prevSaldo + $row->r_m_m_debit;
                    $saldo = $prevSaldo == 0 ? $modal : $tnp_modal;
                    $data[] = array(
                        'no_nota' => $row->r_m_m_id,
                        'transaksi' => $row->r_m_m_keterangan,
                        'masuk' => number_format($masuk),
                        'keluar' => 0,
                        'saldo' => number_format($saldo),
                        'payment' => 1,
                    );
                    $totalMasuk += $row->r_m_m_debit;
                    $prevSaldo = $saldo;
                }
                if ($row->r_m_m_kredit != 0) {
                    $keluar = $row->r_m_m_kredit;
                    $saldo = $prevSaldo - $row->r_m_m_kredit;
                    $data[] = array(
                        'no_nota' => $row->r_m_m_id,
                        'transaksi' => $row->r_m_m_keterangan,
                        'masuk' => 0,
                        'keluar' => number_format($keluar),
                        'saldo' => number_format($saldo),
                        'payment' => 1,
                    );
                    $totalKeluar += $row->r_m_m_kredit;
                    $prevSaldo = $saldo;
                }
            }
            foreach ($transaksi as $row) {
                if ($row->r_t_nominal != 0) {
                    $masuk = number_format($row->r_t_nominal);
                    $saldo = $prevSaldo + $row->r_t_nominal;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Transaksi',
                        'masuk' => $masuk,
                        'keluar' => 0,
                        'saldo' => number_format($saldo),
                        'payment' => 1,
                    );
                    $prevSaldo = $saldo;
                    $totalMasuk += $row->r_t_nominal;
                }
                if ($row->r_t_nominal_pajak != 0) {
                    $masuk = number_format($row->r_t_nominal_pajak);
                    $trans_pajak = $prevSaldo + $row->r_t_nominal_pajak;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Pajak',
                        'masuk' => $masuk,
                        'keluar' => 0,
                        'saldo' => number_format($trans_pajak),
                        'payment' => 1,
                    );
                    $prevSaldo = $trans_pajak;
                    $totalMasuk += $row->r_t_nominal_pajak;
                }
                if ($row->r_t_nominal_sc != 0) {
                    $masuk = number_format($row->r_t_nominal_sc);
                    $trans_sc = $prevSaldo + $row->r_t_nominal_sc;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Servis Charge',
                        'masuk' => $masuk,
                        'keluar' => 0,
                        'saldo' => number_format($trans_sc),
                        'payment' => 1,
                    );
                    $prevSaldo = $trans_sc;
                    $totalMasuk += $row->r_t_nominal_sc;
                }

                if ($row->r_t_nominal_diskon != 0) {
                    $masuk = number_format($row->r_t_nominal_diskon);
                    $trans_diskon = $prevSaldo + $row->r_t_nominal_diskon;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Diskon',
                        'masuk' => $masuk,
                        'keluar' => 0,
                        'saldo' => number_format($trans_diskon),
                        'payment' => 1,
                    );
                    $prevSaldo = $trans_diskon;
                    $totalMasuk += $row->r_t_nominal_diskon;
                    $diskon += $row->r_t_nominal_diskon;
                }
                if ($row->r_t_nominal_voucher != 0) {
                    $masuk = number_format($row->r_t_nominal_voucher);
                    $trans_voucer = $prevSaldo + $row->r_t_nominal_voucher;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Voucher',
                        'masuk' => $masuk,
                        'keluar' => 0,
                        'saldo' => number_format($trans_voucer),
                        'payment' => 1,
                    );
                    $prevSaldo = $trans_voucer;
                    $totalMasuk += $row->r_t_nominal_voucher;
                    $voucher += $row->r_t_nominal_voucher;
                }

                if ($row->r_t_nominal_pembulatan != 0) {
                    $keluar = number_format($row->r_t_nominal_pembulatan);
                    $trans_bulat = $prevSaldo - $row->r_t_nominal_pembulatan;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Pembualatan',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => number_format($trans_bulat),
                        'payment' => 1,
                    );
                    $prevSaldo = $trans_bulat;
                    $totalKeluar += $row->r_t_nominal_pembulatan;
                    $pembulatan += $row->r_t_nominal_pembulatan;
                }
                if ($row->r_t_nominal_tarik_tunai != 0) {
                    $keluar = number_format($row->r_t_nominal_tarik_tunai);
                    $trans_tarik = $prevSaldo - $row->r_t_nominal_tarik_tunai;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Tarik Tunai',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => number_format($trans_tarik),
                        'payment' => 1,
                    );
                    $prevSaldo = $trans_tarik;
                    $totalKeluar += $row->r_t_nominal_tarik_tunai;
                }
                if ($row->r_t_nominal_free_kembalian != 0) {
                    $keluar = number_format($row->r_t_nominal_free_kembalian);
                    $trans_free = $prevSaldo - $row->r_t_nominal_free_kembalian;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Free Kembalian',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => number_format($trans_free),
                        'payment' => 1,
                    );
                    $prevSaldo = $trans_free;
                    $totalKeluar += $row->r_t_nominal_free_kembalian;
                }
            }
            foreach ($refund as $row) {
                if ($row->r_r_nominal_refund != 0) {
                    $keluar = number_format($row->r_r_nominal_refund);
                    $saldo = $prevSaldo - $row->r_r_nominal_refund;
                    $data[] = array(
                        'no_nota' => $row->r_r_nota_code,
                        'transaksi' => 'Refund Nominal',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => number_format($saldo),
                        'payment' => 1,
                    );
                    $prevSaldo = $saldo;
                    $totalKeluar += $row->r_r_nominal_refund;
                }
                if ($row->r_r_nominal_refund_pajak != 0) {
                    $keluar = number_format($row->r_r_nominal_refund_pajak);
                    $saldo = $prevSaldo - $row->r_r_nominal_refund_pajak;
                    $data[] = array(
                        'no_nota' => $row->r_r_nota_code,
                        'transaksi' => 'Refund Pajak',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => number_format($saldo),
                        'payment' => 1,
                    );
                    $prevSaldo = $saldo;
                    $totalKeluar += $row->r_r_nominal_refund_pajak;
                }
                if ($row->r_r_nominal_refund_sc != 0) {
                    $keluar = number_format($row->r_r_nominal_refund_sc);
                    $saldo = $prevSaldo - $row->r_r_nominal_refund_sc;
                    $data[] = array(
                        'no_nota' => $row->r_r_nota_code,
                        'transaksi' => 'Refund Service Charge',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => number_format($saldo),
                        'payment' => 1,
                    );
                    $prevSaldo = $saldo;
                    $totalKeluar += $row->r_r_nominal_refund_sc;
                }
                if ($row->r_r_nominal_pembulatan_refund != 0) {
                    $keluar = number_format($row->r_r_nominal_pembulatan_refund);
                    $saldo = $prevSaldo - $row->r_r_nominal_pembulatan_refund;
                    $data[] = array(
                        'no_nota' => $row->r_r_nota_code,
                        'transaksi' => 'Refund Pembulatan',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => number_format($saldo),
                        'payment' => 1,
                    );
                    $prevSaldo = $saldo;
                    $totalKeluar += $row->r_r_nominal_pembulatan_refund;
                }
                if ($row->r_r_nominal_free_kembalian_refund != 0) {
                    $keluar = number_format($row->r_r_nominal_free_kembalian_refund);
                    $saldo = $prevSaldo - $row->r_r_nominal_free_kembalian_refund;
                    $data[] = array(
                        'no_nota' => $row->r_r_nota_code,
                        'transaksi' => 'Refund Free Kembalian',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => number_format($saldo),
                        'payment' => 1,
                    );
                    $prevSaldo = $saldo;
                    $totalKeluar += $row->r_r_nominal_free_kembalian_refund;
                }
            }
        } // saldo awal
        $saldo_terakhir = end($data)['saldo'];
        $data[] = array(
            'no_nota' => '',
            'transaksi' => '<b>Total</b>',
            'masuk' => '<b>' . number_format($totalMasuk) . '<b>',
            'keluar' => '<b>' . number_format($totalKeluar) . '<b>',
            'saldo' => '<b>' . $saldo_terakhir . '<b>',
            'payment' => 1,
        );
        $data[] = array(
            'no_nota' => '',
            'transaksi' => '<b>Pembulatan</b>',
            'masuk' => '<b>' . number_format($pembulatan) . '<b>',
            'keluar' => '<b>' . number_format($pembulatan) . '<b>',
            'saldo' => '',
            'payment' => 1,
        );
        $data[] = array(
            'no_nota' => '',
            'transaksi' => '<b>Discount</b>',
            'masuk' => '<b>' . number_format($diskon) . '<b>',
            'keluar' => '<b>' . number_format($diskon) . '<b>',
            'saldo' => '',
            'payment' => 1,
        );
        $data[] = array(
            'no_nota' => '',
            'transaksi' => '<b>Voucher</b>',
            'masuk' => '<b>' . number_format($voucher) . '<b>',
            'keluar' => '<b>' . number_format($voucher) . '<b>',
            'saldo' => '',
            'payment' => 1,
        );
        $data[] = array(
            'no_nota' => '',
            'transaksi' => '<b>Grand Total</b>',
            'masuk' => '<b>' . number_format($totalMasuk - $pembulatan - $diskon - $voucher) . '<b>',
            'keluar' => '<b>' . number_format($totalKeluar - $pembulatan - $diskon - $voucher) . '<b>',
            'saldo' => '',
            'payment' => 1,
        );

        //Non Tunai
        $totalKeluarTF = 0;
        $totalMasukTF = 0;
        $prevSaldo = 0;
        $pembulatanTF = 0;
        $discountTF = 0;
        $voucherTF = 0;
        foreach ($transaksi2 as $row) {
            if ($row->r_t_nominal != 0) {
                $masuk = number_format($row->r_t_nominal);
                $saldo = $prevSaldo + $row->r_t_nominal;
                $data[] = array(
                    'no_nota' => $row->r_t_nota_code,
                    'transaksi' => 'Transaksi',
                    'masuk' => $masuk,
                    'keluar' => 0,
                    'saldo' => number_format($saldo),
                    'payment' => 2, 3, 4, 5, 6, 7, 8, 9,
                );
                $prevSaldo = $saldo;
                $totalMasukTF += $row->r_t_nominal;
            }
            if ($row->r_t_nominal_pajak != 0) {
                $masuk = number_format($row->r_t_nominal_pajak);
                $trans_pajak = $prevSaldo + $row->r_t_nominal_pajak;
                $data[] = array(
                    'no_nota' => $row->r_t_nota_code,
                    'transaksi' => 'Pajak',
                    'masuk' => $masuk,
                    'keluar' => 0,
                    'saldo' => number_format($trans_pajak),
                    'payment' => 2, 3, 4, 5, 6, 7, 8, 9,
                );
                $prevSaldo = $trans_pajak;
                $totalMasukTF += $row->r_t_nominal_pajak;
            }
            if ($row->r_t_nominal_sc != 0) {
                $masuk = number_format($row->r_t_nominal_sc);
                $trans_sc = $prevSaldo + $row->r_t_nominal_sc;
                $data[] = array(
                    'no_nota' => $row->r_t_nota_code,
                    'transaksi' => 'Servis Charge',
                    'masuk' => $masuk,
                    'keluar' => 0,
                    'saldo' => number_format($trans_sc),
                    'payment' => 2, 3, 4, 5, 6, 7, 8, 9,
                );
                $prevSaldo = $trans_sc;
                $totalMasukTF += $row->r_t_nominal_sc;
            }
            if ($row->r_t_nominal_diskon != 0) {
                $masuk = number_format($row->r_t_nominal_diskon);
                $trans_diskon = $prevSaldo + $row->r_t_nominal_diskon;
                $data[] = array(
                    'no_nota' => $row->r_t_nota_code,
                    'transaksi' => 'Voucher',
                    'masuk' => $masuk,
                    'keluar' => 0,
                    'saldo' => number_format($trans_diskon),
                    'payment' => 2, 3, 4, 5, 6, 7, 8, 9,
                );
                $prevSaldo = $trans_diskon;
                $totalMasukTF += $row->r_t_nominal_diskon;
                $discountTF += $row->r_t_nominal_diskon;
            }
            if ($row->r_t_nominal_voucher != 0) {
                $masuk = number_format($row->r_t_nominal_voucher);
                $trans_voucer = $prevSaldo + $row->r_t_nominal_voucher;
                $data[] = array(
                    'no_nota' => $row->r_t_nota_code,
                    'transaksi' => 'Voucher',
                    'masuk' => $masuk,
                    'keluar' => 0,
                    'saldo' => number_format($trans_voucer),
                    'payment' => 2, 3, 4, 5, 6, 7, 8, 9,
                );
                $prevSaldo = $trans_voucer;
                $totalMasukTF += $row->r_t_nominal_voucher;
                $voucherTF += $row->r_t_nominal_voucher;
            }
            if ($row->r_t_nominal_pembulatan != 0) {
                $keluar = number_format($row->r_t_nominal_pembulatan);
                $trans_bulat = $prevSaldo - $row->r_t_nominal_pembulatan;
                $data[] = array(
                    'no_nota' => $row->r_t_nota_code,
                    'transaksi' => 'Pembualatan',
                    'masuk' => 0,
                    'keluar' => $keluar,
                    'saldo' => number_format($trans_bulat),
                    'payment' => 2, 3, 4, 5, 6, 7, 8, 9,
                );
                $prevSaldo = $trans_bulat;
                $totalKeluarTF += $row->r_t_nominal_pembulatan;
                $pembulatanTF += $row->r_t_nominal_pembulatan;
            }
            if ($row->r_t_nominal_tarik_tunai != 0) {
                $keluar = number_format($row->r_t_nominal_tarik_tunai);
                $trans_tarik = $prevSaldo - $row->r_t_nominal_tarik_tunai;
                $data[] = array(
                    'no_nota' => $row->r_t_nota_code,
                    'transaksi' => 'Tarik Tunai',
                    'masuk' => 0,
                    'keluar' => $keluar,
                    'saldo' => number_format($trans_tarik),
                    'payment' => 2, 3, 4, 5, 6, 7, 8, 9,
                );
                $prevSaldo = $trans_tarik;
                $totalKeluarTF += $row->r_t_nominal_tarik_tunai;
            }
            if ($row->r_t_nominal_free_kembalian != 0) {
                $keluar = number_format($row->r_t_nominal_free_kembalian);
                $trans_free = $prevSaldo - $row->r_t_nominal_free_kembalian;
                $data[] = array(
                    'no_nota' => $row->r_t_nota_code,
                    'transaksi' => 'Free Kembalian',
                    'masuk' => 0,
                    'keluar' => $keluar,
                    'saldo' => number_format($trans_free),
                    'payment' => 2, 3, 4, 5, 6, 7, 8, 9,
                );
                $prevSaldo = $trans_free;
                $totalKeluarTF += $row->r_t_nominal_free_kembalian;
            }
        } // saldo awal
        $saldo_terakhir = end($data)['saldo'];
        $data[] = array(
            'no_nota' => '',
            'transaksi' => '<b>Total</b>',
            'masuk' => '<b>' . number_format($totalMasukTF) . '</b>',
            'keluar' => '<b>' . number_format($totalKeluarTF) . '</b>',
            'saldo' => '<b>' . $saldo_terakhir . '</b>',
            'payment' => 2, 3, 4, 5, 6, 7, 8, 9,
        );
        $data[] = array(
            'no_nota' => '',
            'transaksi' => '<b>Pembulatan</b>',
            'masuk' => '<b>' . number_format($pembulatanTF) . '</b>',
            'keluar' => '<b>' . number_format($pembulatanTF) . '</b>',
            'saldo' => '',
            'payment' => 2, 3, 4, 5, 6, 7, 8, 9,
        );
        $data[] = array(
            'no_nota' => '',
            'transaksi' => '<b>Discount</b>',
            'masuk' => '<b>' . number_format($voucherTF) . '</b>',
            'keluar' => '<b>' . number_format($voucherTF) . '</b>',
            'saldo' => '',
            'payment' => 2, 3, 4, 5, 6, 7, 8, 9,
        );
        $data[] = array(
            'no_nota' => '',
            'transaksi' => '<b>Voucher</b>',
            'masuk' => '<b>' . number_format($discountTF) . '</b>',
            'keluar' => '<b>' . number_format($discountTF) . '</b>',
            'saldo' => '',
            'payment' => 2, 3, 4, 5, 6, 7, 8, 9,
        );
        $data[] = array(
            'no_nota' => '',
            'transaksi' => '<b>Grand Total</b>',
            'masuk' => '<b>' . number_format($totalMasukTF - $pembulatanTF - $voucherTF - $discountTF) . '</b>',
            'keluar' => '<b>' . number_format($totalKeluarTF - $pembulatanTF - $voucherTF - $discountTF) . '</b>',
            'saldo' => '',
            'payment' => 2, 3, 4, 5, 6, 7, 8, 9,
        );

        $tgl = tgl_indo($request->tanggal);
        $waroeng_nama = $this->getNamaW($request->waroeng);
        $w_nama = strtoupper(substr($waroeng_nama, 0, 3)) . ucwords(substr($waroeng_nama, 3));
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
        $roleJabatan = DB::table('model_has_roles')
            ->rightJoin('users', 'users.users_id', 'model_id')
            ->leftJoin('roles', 'role_id', 'roles.id')
            ->select('roles.name as jabatan')
            ->where('users.name', $nama_kasir->name)
            ->orderBy('waroeng_id', 'asc')
            ->first();
        $jabatan = $roleJabatan->jabatan;

        $pdf = pdf::loadview('dashboard::lap_kas_harian_kasir_pdf', compact('data', 'tgl', 'w_nama', 'kasir', 'shift', 'jabatan'))->setPaper('a4');
        // return view('dashboard::lap_kas_harian_kasir_pdf', compact('data', 'tgl', 'w_nama', 'kasir', 'shift', 'jabatan'));

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
                'saldo' => number_format($valModal->rekap_modal_nominal),
            );
            $totalKeluar = 0;
            $totalMasuk = 0;
            $pembulatan = 0;
            $diskon = 0;
            $voucher = 0;
            $prevSaldo = $valModal->rekap_modal_nominal;
            foreach ($mutasi as $row) {
                if ($row->r_m_m_debit != 0) {
                    $masuk = $row->r_m_m_debit;
                    $modal = $valModal->rekap_modal_nominal + $row->r_m_m_debit;
                    $tnp_modal = $prevSaldo + $row->r_m_m_debit;
                    $saldo = $prevSaldo == 0 ? $modal : $tnp_modal;
                    $data[] = array(
                        'no_nota' => $row->r_m_m_id,
                        'transaksi' => $row->r_m_m_keterangan,
                        'masuk' => number_format($masuk),
                        'keluar' => 0,
                        'saldo' => number_format($saldo),
                    );
                    $totalMasuk += $row->r_m_m_debit;
                    $prevSaldo = $saldo;
                }
                if ($row->r_m_m_kredit != 0) {
                    $keluar = $row->r_m_m_kredit;
                    $saldo = $prevSaldo - $row->r_m_m_kredit;
                    $data[] = array(
                        'no_nota' => $row->r_m_m_id,
                        'transaksi' => $row->r_m_m_keterangan,
                        'masuk' => 0,
                        'keluar' => number_format($keluar),
                        'saldo' => number_format($saldo),
                    );
                    $totalKeluar += $row->r_m_m_kredit;
                    $prevSaldo = $saldo;
                }
            }
            foreach ($transaksi as $row) {
                if ($row->r_t_nominal != 0) {
                    $masuk = number_format($row->r_t_nominal);
                    $saldo = $prevSaldo + $row->r_t_nominal;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Transaksi',
                        'masuk' => $masuk,
                        'keluar' => 0,
                        'saldo' => number_format($saldo),
                    );
                    $prevSaldo = $saldo;
                    $totalMasuk += $row->r_t_nominal;
                }

                if ($row->r_t_nominal_pajak != 0) {
                    $masuk = number_format($row->r_t_nominal_pajak);
                    $trans_pajak = $prevSaldo + $row->r_t_nominal_pajak;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Pajak',
                        'masuk' => $masuk,
                        'keluar' => 0,
                        'saldo' => number_format($trans_pajak),
                    );
                    $prevSaldo = $trans_pajak;
                    $totalMasuk += $row->r_t_nominal_pajak;
                }
                if ($row->r_t_nominal_sc != 0) {
                    $masuk = number_format($row->r_t_nominal_sc);
                    $trans_sc = $prevSaldo + $row->r_t_nominal_sc;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Servis Charge',
                        'masuk' => $masuk,
                        'keluar' => 0,
                        'saldo' => number_format($trans_sc),
                    );
                    $prevSaldo = $trans_sc;
                    $totalMasuk += $row->r_t_nominal_sc;
                }

                if ($row->r_t_nominal_diskon != 0) {
                    $masuk = number_format($row->r_t_nominal_diskon);
                    $trans_diskon = $prevSaldo + $row->r_t_nominal_diskon;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Diskon',
                        'masuk' => $masuk,
                        'keluar' => 0,
                        'saldo' => number_format($trans_diskon),
                    );
                    $prevSaldo = $trans_diskon;
                    $totalMasuk += $row->r_t_nominal_diskon;
                    $diskon += $row->r_t_nominal_diskon;
                }
                if ($row->r_t_nominal_voucher != 0) {
                    $masuk = number_format($row->r_t_nominal_voucher);
                    $trans_voucer = $prevSaldo + $row->r_t_nominal_voucher;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Voucher',
                        'masuk' => $masuk,
                        'keluar' => 0,
                        'saldo' => number_format($trans_voucer),
                    );
                    $prevSaldo = $trans_voucer;
                    $totalMasuk += $row->r_t_nominal_voucher;
                    $voucher += $row->r_t_nominal_voucher;
                }

                if ($row->r_t_nominal_pembulatan != 0) {
                    $keluar = number_format($row->r_t_nominal_pembulatan);
                    $trans_bulat = $prevSaldo - $row->r_t_nominal_pembulatan;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Pembualatan',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => number_format($trans_bulat),
                    );
                    $prevSaldo = $trans_bulat;
                    $totalKeluar += $row->r_t_nominal_pembulatan;
                    $pembulatan += $row->r_t_nominal_pembulatan;
                }
                if ($row->r_t_nominal_tarik_tunai != 0) {
                    $keluar = number_format($row->r_t_nominal_tarik_tunai);
                    $trans_tarik = $prevSaldo - $row->r_t_nominal_tarik_tunai;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Tarik Tunai',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => number_format($trans_tarik),
                    );
                    $prevSaldo = $trans_tarik;
                    $totalKeluar += $row->r_t_nominal_tarik_tunai;
                }
                if ($row->r_t_nominal_free_kembalian != 0) {
                    $keluar = number_format($row->r_t_nominal_free_kembalian);
                    $trans_free = $prevSaldo - $row->r_t_nominal_free_kembalian;
                    $data[] = array(
                        'no_nota' => $row->r_t_nota_code,
                        'transaksi' => 'Free Kembalian',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => number_format($trans_free),
                    );
                    $prevSaldo = $trans_free;
                    $totalKeluar += $row->r_t_nominal_free_kembalian;
                }
            }
            foreach ($refund as $row) {
                if ($row->r_r_nominal_refund != 0) {
                    $keluar = number_format($row->r_r_nominal_refund);
                    $saldo = $prevSaldo - $row->r_r_nominal_refund;
                    $data[] = array(
                        'no_nota' => $row->r_r_nota_code,
                        'transaksi' => 'Refund Nominal',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => number_format($saldo),
                    );
                    $prevSaldo = $saldo;
                    $totalKeluar += $row->r_r_nominal_refund;
                }
                if ($row->r_r_nominal_refund_pajak != 0) {
                    $keluar = number_format($row->r_r_nominal_refund_pajak);
                    $saldo = $prevSaldo - $row->r_r_nominal_refund_pajak;
                    $data[] = array(
                        'no_nota' => $row->r_r_nota_code,
                        'transaksi' => 'Refund Pajak',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => number_format($saldo),
                    );
                    $prevSaldo = $saldo;
                    $totalKeluar += $row->r_r_nominal_refund_pajak;
                }
                if ($row->r_r_nominal_refund_sc != 0) {
                    $keluar = number_format($row->r_r_nominal_refund_sc);
                    $saldo = $prevSaldo - $row->r_r_nominal_refund_sc;
                    $data[] = array(
                        'no_nota' => $row->r_r_nota_code,
                        'transaksi' => 'Refund Service Charge',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => number_format($saldo),
                    );
                    $prevSaldo = $saldo;
                    $totalKeluar += $row->r_r_nominal_refund_sc;
                }
                if ($row->r_r_nominal_pembulatan_refund != 0) {
                    $keluar = number_format($row->r_r_nominal_pembulatan_refund);
                    $saldo = $prevSaldo - $row->r_r_nominal_pembulatan_refund;
                    $data[] = array(
                        'no_nota' => $row->r_r_nota_code,
                        'transaksi' => 'Refund Pembulatan',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => number_format($saldo),
                    );
                    $prevSaldo = $saldo;
                    $totalKeluar += $row->r_r_nominal_pembulatan_refund;
                }
                if ($row->r_r_nominal_free_kembalian_refund != 0) {
                    $keluar = number_format($row->r_r_nominal_free_kembalian_refund);
                    $saldo = $prevSaldo - $row->r_r_nominal_free_kembalian_refund;
                    $data[] = array(
                        'no_nota' => $row->r_r_nota_code,
                        'transaksi' => 'Refund Free Kembalian',
                        'masuk' => 0,
                        'keluar' => $keluar,
                        'saldo' => number_format($saldo),
                    );
                    $prevSaldo = $saldo;
                    $totalKeluar += $row->r_r_nominal_free_kembalian_refund;
                }
            }
        } // saldo awal
        $saldo_terakhir = end($data)['saldo'];
        $data[] = array(
            'no_nota' => '',
            'transaksi' => '<strong> Total </strong>',
            'masuk' => '<strong>' . number_format($totalMasuk) . '</strong>',
            'keluar' => '<strong>' . number_format($totalKeluar) . '</strong>',
            'saldo' => '<strong>' . $saldo_terakhir . '</strong>',
        );
        $data[] = array(
            'no_nota' => '',
            'transaksi' => '<strong> Pembulatan </strong>',
            'masuk' => '<strong>' . number_format($pembulatan) . '</strong>',
            'keluar' => '<strong>' . number_format($pembulatan) . '</strong>',
            'saldo' => '',
        );
        $data[] = array(
            'no_nota' => '',
            'transaksi' => '<strong> Discount </strong>',
            'masuk' => '<strong>' . number_format($diskon) . '</strong>',
            'keluar' => '<strong>' . number_format($diskon) . '</strong>',
            'saldo' => '',
        );
        $data[] = array(
            'no_nota' => '',
            'transaksi' => '<strong> Voucher </strong>',
            'masuk' => '<strong>' . number_format($voucher) . '</strong>',
            'keluar' => '<strong>' . number_format($voucher) . '</strong>',
            'saldo' => '',
        );
        $data[] = array(
            'no_nota' => '',
            'transaksi' => '<strong> Grand Total </strong>',
            'masuk' => '<strong>' . number_format($totalMasuk - $pembulatan - $diskon - $voucher) . '</strong>',
            'keluar' => '<strong>' . number_format($totalKeluar - $pembulatan - $diskon - $voucher) . '</strong>',
            'saldo' => '',
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
            ->where('rekap_modal_status', 'close');
        if ($request->area != 'all') {
            $saldoIn->where('rekap_modal_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $saldoIn->where('rekap_modal_m_w_id', $request->waroeng);
            }
        }
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
