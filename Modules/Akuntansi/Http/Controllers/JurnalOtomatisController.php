<?php

namespace Modules\Akuntansi\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JurnalOtomatisController extends Controller
{

    public function buku_besar()
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
        $data->rekening = DB::table('m_rekening')
            ->select('m_rekening_nama', 'm_rekening_code')
            ->orderBy('m_rekening_code', 'ASC')
            ->groupBy('m_rekening_nama', 'm_rekening_code')
            ->get();
        return view('akuntansi::buku_besar', compact('data'));
    }

    public function jurnal_penjualan()
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
        return view('akuntansi::jurnal_otomatis', compact('data'));
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

    public function tampil_jurnal(Request $request)
    {
        $kas = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Kas Transaksi')
            ->get();
        $nominal_menu = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Nominal Transaksi - Menu')
            ->get();
        $nominal_non_menu = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Nominal Transaksi - Non Menu')
            ->get();
        $nominal_WBD = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Nominal Transaksi - WBD')
            ->get();
        $nominal_usaha = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Nominal Transaksi - Diluar Usaha')
            ->get();
        $nominal_lainlain = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Nominal Transaksi - Lain - Lain')
            ->get();
        $bank_mandiri = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Bank Mandiri')
            ->get();
        $bank_bca = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Bank BCA')
            ->get();
        $gopay = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Gopay')
            ->get();
        $ovo = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Ovo')
            ->get();
        $shopee = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Shopee')
            ->get();
        $ovo = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Ovo')
            ->get();
        $shopee = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Shopee')
            ->get();
        $gopay = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Gopay')
            ->get();
        $pajak = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Pajak Transaksi')
            ->get();
        $sc = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Service Charge Transaksi')
            ->get();
        $tarik = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Tarik Tunai Transaksi')
            ->get();
        $bulat = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Pembulatan Transaksi')
            ->get();
        $free = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Free Kembalian Transaksi')
            ->get();
        $diskon = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Diskon Transaksi')
            ->get();
        $persediaan = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Persediaan Transaksi')
            ->get();
        $biaya_persediaan = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Biaya Persediaan Transaksi')
            ->get();
        $mutasi_keluar = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Mutasi Keluar')
            ->get();
        $mutasi_keluar_ojol = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Mutasi Keluar Ojol')
            ->get();
        $mutasi_masuk = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Mutasi Masuk')
            ->get();
        $mutasi_masuk_ojol = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Mutasi Masuk Ojol')
            ->get();
        $biaya_refund = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Biaya Refund')
            ->get();
        $kas_refund = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Penjualan Refund')
            ->get();
        $nominal_menu_refund = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Nominal Refund - Menu')
            ->get();
        $nominal_non_menu_refund = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Nominal Refund - Non Menu')
            ->get();
        $nominal_wbd_refund = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Nominal Refund - WBD')
            ->get();
        $nominal_usaha_refund = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Nominal Refund - Diluar Usaha')
            ->get();
        $nominal_lainlain_refund = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Nominal Refund - Lain - Lain')
            ->get();
        $pajak_refund = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Pajak Refund')
            ->get();
        $sc_refund = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Service Charge Refund')
            ->get();
        $bulat_refund = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Pembulatan Refund')
            ->get();
        $free_refund = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Free Kembalian Refund')
            ->get();
        $sedia_refund = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Persediaan Refund')
            ->get();
        $biaya_sedia_refund = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Biaya Persediaan Refund')
            ->get();
        $biaya_lostbill = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Biaya Lostbill')
            ->get();
        $penjualan_lostbill = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Penjualan Lostbill')
            ->get();
        // $nominal_menu_lostbill = DB::table('m_link_akuntansi')
        //     ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
        //     ->where('m_link_akuntansi_nama', 'Nominal Lostbill - Menu')
        //     ->get();
        // $nominal_non_menu_lostbill = DB::table('m_link_akuntansi')
        //     ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
        //     ->where('m_link_akuntansi_nama', 'Nominal Lostbill - Non Menu')
        //     ->get();
        // $nominal_wbd_lostbill = DB::table('m_link_akuntansi')
        //     ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
        //     ->where('m_link_akuntansi_nama', 'Nominal Lostbill - WBD')
        //     ->get();
        // $nominal_usaha_lostbill = DB::table('m_link_akuntansi')
        //     ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
        //     ->where('m_link_akuntansi_nama', 'Nominal Lostbill - Diluar Usaha')
        //     ->get();
        #nominal lostbill digabung menjadi biaya
        $pajak_lostbill = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Pajak Lostbill')
            ->get();
        $sedia_lostbill = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Persediaan Lostbill')
            ->get();
        $biaya_sedia_lostbill = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Biaya Persediaan Lostbill')
            ->get();
        $biaya_garansi = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Biaya Garansi')
            ->get();
        $penjualan_garansi = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Penjualan Garansi')
            ->get();
        // $nominal_menu_garansi = DB::table('m_link_akuntansi')
        //     ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
        //     ->where('m_link_akuntansi_nama', 'Nominal Garansi - Menu')
        //     ->get();
        // $nominal_non_menu_garansi = DB::table('m_link_akuntansi')
        //     ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
        //     ->where('m_link_akuntansi_nama', 'Nominal Garansi - Non Menu')
        //     ->get();
        // $nominal_wbd_garansi = DB::table('m_link_akuntansi')
        //     ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
        //     ->where('m_link_akuntansi_nama', 'Nominal Garansi - WBD')
        //     ->get();
        // $nominal_usaha_garansi = DB::table('m_link_akuntansi')
        //     ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
        //     ->where('m_link_akuntansi_nama', 'Nominal Garansi - Diluar Usaha')
        //     ->get();
        // $pajak_garansi = DB::table('m_link_akuntansi')
        //     ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
        //     ->where('m_link_akuntansi_nama', 'Pajak Garansi')
        //     ->get();
        #nominal garansi digabung menjadi biaya
        $sedia_garansi = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Persediaan Garansi')
            ->get();
        $biaya_sedia_garansi = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Biaya Persediaan Garansi')
            ->get();
        $kas_mutasi = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Kas Mutasi')
            ->get();
        $mutasi_keluar = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Mutasi Keluar')
            ->get();
        $mutasi_masuk = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Mutasi Masuk')
            ->get();
        // $selisih_kasir = DB::table('m_link_akuntansi')
        //     ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
        //     ->where('m_link_akuntansi_nama', 'Selisih Kasir')
        //     ->get();
        // $pendapatan_selisih_kasir = DB::table('m_link_akuntansi')
        //     ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
        //     ->where('m_link_akuntansi_nama', 'Pendapatan Selisih Kasir')
        //     ->get();
        // $biaya_selisih_kasir = DB::table('m_link_akuntansi')
        //     ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
        //     ->where('m_link_akuntansi_nama', 'Biaya Selisih Kasir')
        //     ->get();
        $nominal_tambahan_ojol = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->where('m_link_akuntansi_nama', 'Nominal Tambahan Ojol')
            ->get();

        $kas_transaksi_1 = DB::table('rekap_transaksi_detail')
            ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
            ->join('rekap_payment_transaksi', 'r_p_t_r_t_id', 'r_t_id')
            ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
            ->selectRaw('max(r_t_tanggal) r_t_tanggal,
                                max(r_t_nota_code) r_t_nota_code,
                                r_t_m_w_code,
                                r_t_id kode_id,
                                rekap_modal_sesi as sesi,
                                max(r_p_t_m_payment_method_id) pay_method,
                                r_t_detail_m_produk_id as produk_id,
                                SUM(r_t_detail_price*r_t_detail_qty) nominal,
                                sum(r_t_detail_nominal_pajak) as pajak,
                                sum(r_t_detail_nominal_sc) as sc,
                                max(r_t_m_t_t_id) type_trans,
                                max(r_t_nominal_tarik_tunai) as tarik,
                                max(r_t_nominal_free_kembalian) as free,
                                max(r_t_nominal_pembulatan) as pembulatan,
                                max(r_t_nominal_diskon) as diskon,
                                SUM(r_t_nominal_sharing_profit_in + r_t_nominal_sharing_profit_out) as sharing')
            ->where('r_t_m_w_id', $request->waroeng);
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $kas_transaksi_1->whereBetween('r_t_tanggal', [$start, $end]);
        } else {
            $kas_transaksi_1->where('r_t_tanggal', $request->tanggal);
        }
        // if ($request->payment != 'all') {
        //     $kas_transaksi_1->where('r_p_t_m_payment_method_id', $request->payment);
        // }
        $kas_transaksi = $kas_transaksi_1->groupby('r_t_m_w_code', 'kode_id', 'r_t_detail_m_produk_id', 'sesi')
            ->where('r_t_detail_status', 'paid')
            ->where('r_t_status', 'paid')
            ->orderby('sesi', 'ASC')
            ->orderby('kode_id', 'ASC')
            ->get();

        if ($kas_transaksi->first() == null) {
            return response()->json(['messages' => 'Tidak ada transaksi pada metode pembayaran ini', 'type' => 'error']);
        }

        $lostbill = DB::table('rekap_transaksi_detail')
            ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
            ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
            ->selectRaw('max(r_t_tanggal) r_t_tanggal,
                        r_t_detail_m_produk_id as produk_id,
                        max(r_t_nota_code) r_t_nota_code,
                        r_t_m_w_code,
                        r_t_id kode_id,
                        rekap_modal_sesi as sesi,
                        max(r_t_m_t_t_id) type_trans,
                        sum(r_t_detail_price * r_t_detail_qty) as nominal,
                        sum(r_t_detail_nominal_pajak) as pajak,
                        sum(r_t_detail_nominal_sc) as sc,
                        SUM(r_t_nominal_sharing_profit_in + r_t_nominal_sharing_profit_out) as sharing');
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $lostbill->whereBetween('r_t_tanggal', [$start, $end]);
        } else {
            $lostbill->where('r_t_tanggal', $request->tanggal);
        }
        $lostbill = $lostbill->groupby('r_t_m_w_code', 'kode_id', 'r_t_detail_m_produk_id', 'sesi')
            ->where('r_t_detail_status', 'unpaid')
            ->where('r_t_status', 'unpaid')
            ->where('r_t_m_w_id', $request->waroeng)
            ->orderby('sesi', 'ASC')
            ->orderby('kode_id', 'ASC')
            ->get();

        $refund = DB::table('rekap_refund_detail')
            ->join('rekap_refund', 'r_r_id', 'r_r_detail_r_r_id')
            ->join('rekap_transaksi', 'r_t_id', 'r_r_r_t_id')
            ->join('rekap_payment_transaksi', 'r_p_t_r_t_id', 'r_t_id')
            ->join('rekap_modal', 'rekap_modal_id', 'r_r_rekap_modal_id')
            ->selectRaw('max(r_r_tanggal) r_r_tanggal,
                                max(r_t_tanggal) r_t_tanggal,
                                max(r_r_nota_code) r_r_nota_code,
                                r_r_m_w_code,
                                r_r_id kode_id,
                                r_r_detail_m_produk_id as produk_id,
                                rekap_modal_sesi sesi,
                                SUM(r_r_detail_price * r_r_detail_qty) nominal,
                                sum(r_r_detail_nominal_pajak) as pajak,
                                sum(r_r_detail_nominal_sc) as sc,
                                max(r_t_m_t_t_id) type_trans,
                                max(r_r_nominal_free_kembalian_refund) as free,
                                max(r_r_nominal_pembulatan_refund) as pembulatan,
                                sum(r_r_detail_nominal_sharing_profit_in + r_r_detail_nominal_sharing_profit_out) as sharing');
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $refund->whereBetween('r_r_tanggal', [$start, $end]);
        } else {
            $refund->where('r_r_tanggal', $request->tanggal);
        }
        // if ($request->payment != 'all') {
        //     $refund->where('r_p_t_m_payment_method_id', $request->payment);
        // }
        $refund = $refund->groupby('r_r_m_w_code', 'kode_id', 'produk_id', 'sesi')
            ->where('r_r_m_w_id', $request->waroeng)
            ->orderby('sesi', 'ASC')
            ->orderby('kode_id', 'ASC')
            ->get();

        $garansi = DB::table('rekap_garansi')
            ->join('rekap_transaksi', 'r_t_id', 'rekap_garansi_r_t_id')
            ->join('rekap_payment_transaksi', 'r_p_t_r_t_id', 'r_t_id')
            ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
            ->selectRaw('max(r_t_tanggal) r_t_tanggal,
                        max(r_t_nota_code) r_t_nota_code,
                        r_t_m_w_code,
                        r_t_id kode_id,
                        rekap_modal_sesi as sesi,
                        rekap_garansi_keterangan catatan,
                        max(r_p_t_m_payment_method_id) pay_method,
                        rekap_garansi_m_produk_id as produk_id,
                        SUM(rekap_garansi_price * rekap_garansi_qty) nominal,
                        SUM(r_t_nominal_sharing_profit_in + r_t_nominal_sharing_profit_out) as sharing');
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $garansi->whereBetween('r_t_tanggal', [$start, $end]);
        } else {
            $garansi->where('r_t_tanggal', $request->tanggal);
        }
        // if ($request->payment != 'all') {
        //     $garansi->where('r_p_t_m_payment_method_id', $request->payment);
        // }
        $garansi = $garansi->groupby('r_t_m_w_code', 'kode_id', 'produk_id', 'sesi', 'rekap_garansi_keterangan')
            ->where('r_t_m_w_id', $request->waroeng)
            ->orderby('sesi', 'ASC')
            ->orderby('kode_id', 'ASC')
            ->get();

        $mutasi = DB::table('rekap_mutasi_modal')
            ->join('rekap_modal', 'rekap_modal_id', 'r_m_m_rekap_modal_id')
            ->selectRaw('max(r_m_m_tanggal) tanggal,
                        max(r_m_m_m_w_code) m_w_code,
                        r_m_m_id kode_id,
                        rekap_modal_sesi as sesi,
                        r_m_m_keterangan catatan,
                        max(r_m_m_debit) debit,
                        max(r_m_m_kredit) kredit');
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $mutasi->whereBetween('r_m_m_tanggal', [$start, $end]);
        } else {
            $mutasi->where('r_m_m_tanggal', $request->tanggal);
        }
        $mutasi = $mutasi->groupby('kode_id', 'sesi', 'catatan')
            ->where('r_m_m_m_w_id', $request->waroeng)
            ->orderby('sesi', 'ASC')
            ->orderby('kode_id', 'ASC')
            ->get();

        $selisih = DB::table('rekap_modal')
            ->selectRaw('DATE(max(rekap_modal_tanggal)) tanggal,
                        max(rekap_modal_m_w_code) m_w_code,
                        rekap_modal_id kode_id,
                        rekap_modal_sesi as sesi,
                        max(rekap_modal_keterangan) catatan,
                        sum(rekap_modal_cash_real - (rekap_modal_nominal+rekap_modal_cash_in-rekap_modal_cash_out)) nominal');
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $selisih->whereBetween(DB::raw('DATE(rekap_modal_tanggal)'), [$start, $end]);
        } else {
            $selisih->where(DB::raw('DATE(rekap_modal_tanggal)'), $request->tanggal);
        }
        $selisih = $selisih->groupby('kode_id', 'sesi')
            ->where('rekap_modal_m_w_id', $request->waroeng)
            ->orderby('sesi', 'ASC')
            ->orderby('kode_id', 'ASC')
            ->get();

        //transaksi
        $arrayListTrans = [];
        foreach ($kas_transaksi as $keyRekap => $valRekap) {
            array_push($arrayListTrans, $valRekap->kode_id);
        }
        $listRekap = array_unique($arrayListTrans);

        //refund
        $arrayListRefund = [];
        foreach ($refund as $keyRekap => $valRekap) {
            array_push($arrayListRefund, $valRekap->kode_id);
        }
        $listRefund = array_unique($arrayListRefund);

        //lostbill
        $arrayListLostbill = [];
        foreach ($lostbill as $keyRekap => $valRekap) {
            array_push($arrayListLostbill, $valRekap->kode_id);
        }
        $listLostbill = array_unique($arrayListLostbill);

        //garansi
        $arrayListGaransi = [];
        foreach ($garansi as $keyRekap => $valRekap) {
            array_push($arrayListGaransi, $valRekap->kode_id);
        }
        $listGaransi = array_unique($arrayListGaransi);

        //mutasi
        $arrayListMutasi = [];
        foreach ($mutasi as $keyRekap => $valRekap) {
            array_push($arrayListMutasi, $valRekap->kode_id);
        }
        $listMutasi = array_unique($arrayListMutasi);

        //selisih kasir
        $arrayListSelisihKasir = [];
        foreach ($selisih as $keyRekap => $valRekap) {
            array_push($arrayListSelisihKasir, $valRekap->kode_id);
        }
        $listSelisihKasir = array_unique($arrayListSelisihKasir);

        $listMenu = DB::table('m_produk')
            ->whereNotIn('m_produk_m_jenis_produk_id', [9, 11, 12, 13])
            ->pluck('m_produk_id')
            ->toArray();

        $listNonMenu = DB::table('m_produk')
            ->whereIn('m_produk_m_jenis_produk_id', [9, 11])
            ->pluck('m_produk_id')
            ->toArray();

        $listWbd = DB::table('m_produk')
            ->whereIn('m_produk_m_jenis_produk_id', [11])
            ->pluck('m_produk_id')
            ->toArray();

        $diLuarUsaha = DB::table('m_produk')
            ->join('config_sub_jenis_produk', 'config_sub_jenis_produk_m_produk_id', '=', 'm_produk_id')
            ->whereIn('config_sub_jenis_produk_m_sub_jenis_produk_id', [20, 22, 23, 24, 25])
            ->pluck('m_produk_id')
            ->toArray();

        $lainLain = DB::table('m_produk')
            ->whereIn('m_produk_id', [660, 661, 948])
            ->pluck('m_produk_id')
            ->toArray();

        $data = array();
        $sortedData = array();
        $totalDebit = 0;
        $totalKredit = 0;
        foreach ($listRekap as $key => $notaCode) {
            ${$notaCode . '-menu'} = 0;
            ${$notaCode . '-nonmenu'} = 0;
            ${$notaCode . '-wbd'} = 0;
            ${$notaCode . '-diluarusaha'} = 0;
            ${$notaCode . '-lainlain'} = 0;
            ${$notaCode . '-sharing'} = 0;
            ${$notaCode . '-pajak'} = 0;
            ${$notaCode . '-persediaan'} = 0;
            foreach ($kas_transaksi as $keyTrans => $kasTrans) {
                if ($kasTrans->kode_id == $notaCode) {
                    $listAll = array_merge($listMenu, $listNonMenu, $listWbd, $diLuarUsaha);
                    if (in_array($kasTrans->produk_id, $listMenu)) {
                        $nominal = $kasTrans->nominal;
                        ${$notaCode . '-menu'} += $nominal;
                    }
                    if (in_array($kasTrans->produk_id, $listNonMenu)) {
                        $nominal = $kasTrans->nominal;
                        ${$notaCode . '-nonmenu'} += $nominal;
                    }
                    if (in_array($kasTrans->produk_id, $listWbd)) {
                        $nominal = $kasTrans->nominal;
                        ${$notaCode . '-wbd'} += $nominal;
                    }
                    if (in_array($kasTrans->produk_id, $diLuarUsaha)) {
                        $nominal = $kasTrans->nominal;
                        ${$notaCode . '-diluarusaha'} += $nominal;
                    }
                    if (in_array($kasTrans->produk_id, $lainLain)) {
                        $nominal = $kasTrans->nominal;
                        ${$notaCode . '-lainlain'} += $nominal;
                    }
                    if (in_array($kasTrans->produk_id, $listAll)) {
                        $nominal = $kasTrans->nominal * 0.1;
                        ${$notaCode . '-sharing'} += $nominal;
                    }
                    if (in_array($kasTrans->type_trans, [1, 2])) {
                        $nominal = $kasTrans->pajak;
                        ${$notaCode . '-pajak'} += $nominal;
                    }
                    if (in_array($kasTrans->produk_id, $listAll)) {
                        $nominal = $kasTrans->nominal * 0.8;
                        ${$notaCode . '-persediaan'} += $nominal;
                    }
                    $urutan = 1;
                    if ($kasTrans->pay_method == 1) {
                        foreach ($kas as $valKas) {
                            if ($request->status == 'jurnal' || ($request->akun == $valKas->m_rekening_code && $request->status == 'buku besar')) {
                                $akun = $valKas->m_rekening_nama;
                                if (${$notaCode . '-menu'} != 0) {
                                    $data[$notaCode]['Kas Menu'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $akun,
                                        'particul' => 'penjualan menu (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-menu'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-nonmenu'} != 0) {
                                    $data[$notaCode]['Kas Non Menu'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $akun,
                                        'particul' => 'penjualan non menu (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-nonmenu'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-wbd'} != 0) {
                                    $data[$notaCode]['Kas WBD'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $akun,
                                        'particul' => 'penjualan wbd (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-wbd'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-diluarusaha'} != 0) {
                                    $data[$notaCode]['Kas Di luar Usaha'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $akun,
                                        'particul' => 'penjualan diluar usaha (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-diluarusaha'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-lainlain'} != 0) {
                                    $data[$notaCode]['Kas Lain - Lain'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $akun,
                                        'particul' => 'pendapatan lain-lain (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-lainlain'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }

                                if (${$notaCode . '-pajak'} != 0) {
                                    $data[$notaCode]['Kas Pajak'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $akun,
                                        'particul' => 'pajak penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-pajak'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->sc != 0) {
                                    $data[$notaCode]['Kas SC'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $akun,
                                        'particul' => 'sc penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->sc),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->tarik != 0) {
                                    $data[$notaCode]['Kas Tarik Tunai'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $akun,
                                        'particul' => 'tarik tunai (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->tarik),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->free != 0) {
                                    $data[$notaCode]['Kas Free'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $akun,
                                        'particul' => 'free kembalian (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->free),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->pembulatan != 0) {
                                    $data[$notaCode]['Kas Bulat'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $akun,
                                        'particul' => 'pembulatan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->pembulatan),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->diskon != 0) {
                                    $data[$notaCode]['Kas Diskon'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $akun,
                                        'particul' => 'diskon penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->diskon),
                                        'urutan' => $urutan++,
                                    );
                                }
                            } //link kas
                        }
                        if (${$notaCode . '-menu'} != 0) {
                            foreach ($nominal_menu as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Menu Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'penjualan menu (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-menu'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-nonmenu'} != 0) {
                            foreach ($nominal_non_menu as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Non Menu Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'penjualan non menu (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-nonmenu'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-wbd'} != 0) {
                            foreach ($nominal_WBD as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Wbd Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'penjualan wbd (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-wbd'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-diluarusaha'} != 0) {
                            foreach ($nominal_usaha as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Di luar Usaha Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'penjualan diluar usaha (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-diluarusaha'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-lainlain'} != 0) {
                            foreach ($nominal_lainlain as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Lain - Lain'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'pendapatan lain-lain (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-lainlain'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-pajak'} != 0) {
                            foreach ($pajak as $valPajak) {
                                if ($request->status == 'jurnal' || ($request->akun == $valPajak->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pajak Ditahan Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valPajak->m_rekening_code,
                                        'akun' => $valPajak->m_rekening_nama,
                                        'particul' => 'pajak penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-pajak'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->sc != 0) {
                            foreach ($sc as $valsc) {
                                if ($request->status == 'jurnal' || ($request->akun == $valsc->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['SC Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valsc->m_rekening_code,
                                        'akun' => $valsc->m_rekening_nama,
                                        'particul' => 'sc penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->sc),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->tarik != 0) {
                            foreach ($tarik as $valTarik) {
                                if ($request->status == 'jurnal' || ($request->akun == $valTarik->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Tarik Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valTarik->m_rekening_code,
                                        'akun' => $valTarik->m_rekening_nama,
                                        'particul' => 'tarik tunai (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->tarik),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->pembulatan != 0) {
                            foreach ($bulat as $valBulat) {
                                if ($request->status == 'jurnal' || ($request->akun == $valBulat->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pembulatan Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valBulat->m_rekening_code,
                                        'akun' => $valBulat->m_rekening_nama,
                                        'particul' => 'pembulatan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->pembulatan),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->free != 0) {
                            foreach ($free as $valFree) {
                                if ($request->status == 'jurnal' || ($request->akun == $valFree->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['free Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valFree->m_rekening_code,
                                        'akun' => $valFree->m_rekening_nama,
                                        'particul' => 'free kembalian (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->free),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->diskon != 0) {
                            foreach ($diskon as $valDiskon) {
                                if ($request->status == 'jurnal' || ($request->akun == $valDiskon->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Diskon Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valDiskon->m_rekening_code,
                                        'akun' => $valDiskon->m_rekening_nama,
                                        'particul' => 'diskon penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->diskon),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-persediaan'} != 0) {
                            foreach ($persediaan as $valSedia) {
                                if ($request->status == 'jurnal' || ($request->akun == $valSedia->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Persediaan Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valSedia->m_rekening_code,
                                        'akun' => $valSedia->m_rekening_nama,
                                        'particul' => 'persediaan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-persediaan'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        foreach ($biaya_persediaan as $valBiayaSedia) {
                            if (${$notaCode . '-persediaan'} != 0) {
                                if ($request->status == 'jurnal' || ($request->akun == $valBiayaSedia->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Biaya Persediaan Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valBiayaSedia->m_rekening_code,
                                        'akun' => $valBiayaSedia->m_rekening_nama,
                                        'particul' => 'biaya persediaan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-persediaan'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                    } elseif (in_array($kasTrans->pay_method, [2, 3, 4])) {
                        foreach ($bank_mandiri as $valKas) {
                            if ($request->status == 'jurnal' || ($request->akun == $valKas->m_rekening_code && $request->status == 'buku besar')) {
                                if (${$notaCode . '-menu'} != 0) {
                                    $data[$notaCode]['Mandiri Menu'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'penjualan menu (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-menu'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-nonmenu'} != 0) {
                                    $data[$notaCode]['Mandiri Non Menu'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'penjualan non menu (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-nonmenu'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-wbd'} != 0) {
                                    $data[$notaCode]['Mandiri WBD'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'penjualan wbd (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-wbd'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-diluarusaha'} != 0) {
                                    $data[$notaCode]['Mandiri Di luar Usaha'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'penjualan diluar usaha (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-diluarusaha'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-lainlain'} != 0) {
                                    $data[$notaCode]['Mandiri Lain - Lain'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'pendapatan lain-lain (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-lainlain'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }

                                if (${$notaCode . '-pajak'} != 0) {
                                    $data[$notaCode]['Mandiri Pajak'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'pajak penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-pajak'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->sc != 0) {
                                    $data[$notaCode]['Mandiri SC'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'sc penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->sc),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->tarik != 0) {
                                    $data[$notaCode]['Mandiri Tarik Tunai'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'tarik tunai (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->tarik),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->free != 0) {
                                    $data[$notaCode]['Mandiri Free'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'free kembalian (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->free),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->pembulatan != 0) {
                                    $data[$notaCode]['Mandiri Bulat'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'pembulatan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->pembulatan),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->diskon != 0) {
                                    $data[$notaCode]['Mandiri Diskon'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'diskon penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->diskon),
                                        'urutan' => $urutan++,
                                    );
                                }
                            } //link mandiri
                        }
                        if (${$notaCode . '-menu'} != 0) {
                            foreach ($nominal_menu as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Menu Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'penjualan menu (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-menu'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-nonmenu'} != 0) {
                            foreach ($nominal_non_menu as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Non Menu Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'penjualan non menu (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-nonmenu'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-wbd'} != 0) {
                            foreach ($nominal_WBD as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Wbd Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'penjualan wbd (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-wbd'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-diluarusaha'} != 0) {
                            foreach ($nominal_usaha as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Di luar Usaha Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'penjualan diluar usaha (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-diluarusaha'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-lainlain'} != 0) {
                            foreach ($nominal_lainlain as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Lain - Lain'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'pendapatan lain-lain (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-lainlain'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-pajak'} != 0) {
                            foreach ($pajak as $valPajak) {
                                if ($request->status == 'jurnal' || ($request->akun == $valPajak->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pajak Ditahan Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valPajak->m_rekening_code,
                                        'akun' => $valPajak->m_rekening_nama,
                                        'particul' => 'pajak penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-pajak'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->sc != 0) {
                            foreach ($sc as $valsc) {
                                if ($request->status == 'jurnal' || ($request->akun == $valsc->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['SC Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valsc->m_rekening_code,
                                        'akun' => $valsc->m_rekening_nama,
                                        'particul' => 'sc penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->sc),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->tarik != 0) {
                            foreach ($tarik as $valTarik) {
                                if ($request->status == 'jurnal' || ($request->akun == $valTarik->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Tarik Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valTarik->m_rekening_code,
                                        'akun' => $valTarik->m_rekening_nama,
                                        'particul' => 'tarik tunai (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->tarik),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->pembulatan != 0) {
                            foreach ($bulat as $valBulat) {
                                if ($request->status == 'jurnal' || ($request->akun == $valBulat->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pembulatan Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valBulat->m_rekening_code,
                                        'akun' => $valBulat->m_rekening_nama,
                                        'particul' => 'pembulatan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->pembulatan),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->free != 0) {
                            foreach ($free as $valFree) {
                                if ($request->status == 'jurnal' || ($request->akun == $valFree->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['free Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valFree->m_rekening_code,
                                        'akun' => $valFree->m_rekening_nama,
                                        'particul' => 'free kembalian (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->free),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->diskon != 0) {
                            foreach ($diskon as $valDiskon) {
                                if ($request->status == 'jurnal' || ($request->akun == $valDiskon->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Diskon Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valDiskon->m_rekening_code,
                                        'akun' => $valDiskon->m_rekening_nama,
                                        'particul' => 'diskon penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->diskon),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-persediaan'} != 0) {
                            foreach ($persediaan as $valSedia) {
                                if ($request->status == 'jurnal' || ($request->akun == $valSedia->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Persediaan Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valSedia->m_rekening_code,
                                        'akun' => $valSedia->m_rekening_nama,
                                        'particul' => 'persediaan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-persediaan'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-persediaan'} != 0) {
                            foreach ($biaya_persediaan as $valBiayaSedia) {
                                if ($request->status == 'jurnal' || ($request->akun == $valBiayaSedia->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Biaya Persediaan Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valBiayaSedia->m_rekening_code,
                                        'akun' => $valBiayaSedia->m_rekening_nama,
                                        'particul' => 'biaya persediaan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-persediaan'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                    } elseif (in_array($kasTrans->pay_method, [5, 9])) {
                        foreach ($bank_bca as $valKas) {
                            if ($request->status == 'jurnal' || ($request->akun == $valKas->m_rekening_code && $request->status == 'buku besar')) {
                                if (${$notaCode . '-menu'} != 0) {
                                    $data[$notaCode]['BCA Menu'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'penjualan menu (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-menu'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-nonmenu'} != 0) {
                                    $data[$notaCode]['BCA Non Menu'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'penjualan non menu (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-nonmenu'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-wbd'} != 0) {
                                    $data[$notaCode]['BCA WBD'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'penjualan wbd (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-wbd'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-diluarusaha'} != 0) {
                                    $data[$notaCode]['BCA Di luar Usaha'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'penjualan diluar usaha (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-diluarusaha'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-lainlain'} != 0) {
                                    $data[$notaCode]['BCA Lain - Lain'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'pendapatan lain-lain (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-lainlain'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }

                                if (${$notaCode . '-pajak'} != 0) {
                                    $data[$notaCode]['BCA Pajak'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'pajak penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-pajak'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->sc != 0) {
                                    $data[$notaCode]['BCA SC'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'sc penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->sc),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->tarik != 0) {
                                    $data[$notaCode]['BCA Tarik Tunai'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'tarik tunai (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->tarik),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->free != 0) {
                                    $data[$notaCode]['BCA Free'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'free kembalian (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->free),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->pembulatan != 0) {
                                    $data[$notaCode]['BCA Bulat'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'pembulatan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->pembulatan),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->diskon != 0) {
                                    $data[$notaCode]['BCA Diskon'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'diskon penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->diskon),
                                        'urutan' => $urutan++,
                                    );
                                }
                            } //link bca
                        }
                        if (${$notaCode . '-menu'} != 0) {
                            foreach ($nominal_menu as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Menu Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'penjualan menu (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-menu'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-nonmenu'} != 0) {
                            foreach ($nominal_non_menu as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Non Menu Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'penjualan non menu (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-nonmenu'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-wbd'} != 0) {
                            foreach ($nominal_WBD as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Wbd Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'penjualan wbd (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-wbd'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-diluarusaha'} != 0) {
                            foreach ($nominal_usaha as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Di luar Usaha Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'penjualan diluar usaha (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-diluarusaha'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-lainlain'} != 0) {
                            foreach ($nominal_lainlain as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Lain - Lain'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'pendapatan lain-lain (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-lainlain'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-pajak'} != 0) {
                            foreach ($pajak as $valPajak) {
                                if ($request->status == 'jurnal' || ($request->akun == $valPajak->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pajak Ditahan Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valPajak->m_rekening_code,
                                        'akun' => $valPajak->m_rekening_nama,
                                        'particul' => 'pajak penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-pajak'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->sc != 0) {
                            foreach ($sc as $valsc) {
                                if ($request->status == 'jurnal' || ($request->akun == $valsc->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['SC Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valsc->m_rekening_code,
                                        'akun' => $valsc->m_rekening_nama,
                                        'particul' => 'sc penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->sc),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->tarik != 0) {
                            foreach ($tarik as $valTarik) {
                                if ($request->status == 'jurnal' || ($request->akun == $valTarik->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Tarik Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valTarik->m_rekening_code,
                                        'akun' => $valTarik->m_rekening_nama,
                                        'particul' => 'tarik tunai (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->tarik),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->pembulatan != 0) {
                            foreach ($bulat as $valBulat) {
                                if ($request->status == 'jurnal' || ($request->akun == $valBulat->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pembulatan Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valBulat->m_rekening_code,
                                        'akun' => $valBulat->m_rekening_nama,
                                        'particul' => 'pembulatan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->pembulatan),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->free != 0) {
                            foreach ($free as $valFree) {
                                if ($request->status == 'jurnal' || ($request->akun == $valFree->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['free Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valFree->m_rekening_code,
                                        'akun' => $valFree->m_rekening_nama,
                                        'particul' => 'free kembalian (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->free),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->diskon != 0) {
                            foreach ($diskon as $valDiskon) {
                                if ($request->status == 'jurnal' || ($request->akun == $valDiskon->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Diskon Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valDiskon->m_rekening_code,
                                        'akun' => $valDiskon->m_rekening_nama,
                                        'particul' => 'diskon penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->diskon),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-persediaan'} != 0) {
                            foreach ($persediaan as $valSedia) {
                                if ($request->status == 'jurnal' || ($request->akun == $valSedia->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Persediaan Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valSedia->m_rekening_code,
                                        'akun' => $valSedia->m_rekening_nama,
                                        'particul' => 'persediaan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-persediaan'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-persediaan'} != 0) {
                            foreach ($biaya_persediaan as $valBiayaSedia) {
                                if ($request->status == 'jurnal' || ($request->akun == $valBiayaSedia->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Biaya Persediaan Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valBiayaSedia->m_rekening_code,
                                        'akun' => $valBiayaSedia->m_rekening_nama,
                                        'particul' => 'biaya persediaan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-persediaan'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                    } elseif ($kasTrans->pay_method == 6) {
                        foreach ($gopay as $valKas) {
                            if ($request->status == 'jurnal' || ($request->akun == $valKas->m_rekening_code && $request->status == 'buku besar')) {
                                if (${$notaCode . '-menu'} != 0) {
                                    $data[$notaCode]['Gopay Menu'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'penjualan menu (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-menu'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-nonmenu'} != 0) {
                                    $data[$notaCode]['Gopay Non Menu'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'penjualan non menu (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-nonmenu'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-wbd'} != 0) {
                                    $data[$notaCode]['Gopay WBD'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'penjualan wbd (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-wbd'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-diluarusaha'} != 0) {
                                    $data[$notaCode]['Gopay Di luar Usaha'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'penjualan diluar usaha (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-diluarusaha'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-lainlain'} != 0) {
                                    $data[$notaCode]['Gopay Lain - Lain'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'pendapatan lain-lain (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-lainlain'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }

                                if (${$notaCode . '-sharing'} != 0) {
                                    $data[$notaCode]['Gopay Sharing'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'pajak ojol (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-sharing'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-pajak'} != 0) {
                                    $data[$notaCode]['Gopay Pajak'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'pajak penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-pajak'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->sc != 0) {
                                    $data[$notaCode]['Gopay SC'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'sc penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->sc),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->tarik != 0) {
                                    $data[$notaCode]['Gopay Tarik Tunai'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'tarik tunai (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->tarik),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->free != 0) {
                                    $data[$notaCode]['Gopay Free'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'free kembalian (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->free),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->pembulatan != 0) {
                                    $data[$notaCode]['Gopay Bulat'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'pembulatan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->pembulatan),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->diskon != 0) {
                                    $data[$notaCode]['Gopay Diskon'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'diskon penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->diskon),
                                        'urutan' => $urutan++,
                                    );
                                }
                            } //link gopay
                        }
                        if (${$notaCode . '-menu'} != 0) {
                            foreach ($nominal_menu as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Menu Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'penjualan menu (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-menu'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-nonmenu'} != 0) {
                            foreach ($nominal_non_menu as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Non Menu Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'penjualan non menu (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-nonmenu'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-wbd'} != 0) {
                            foreach ($nominal_WBD as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Wbd Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'penjualan wbd (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-wbd'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-diluarusaha'} != 0) {
                            foreach ($nominal_usaha as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Di luar Usaha Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'penjualan diluar usaha (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-diluarusaha'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-lainlain'} != 0) {
                            foreach ($nominal_lainlain as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Lain - Lain'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'pendapatan lain-lain (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-lainlain'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-sharing'} != 0) {
                            foreach ($nominal_tambahan_ojol as $valSharing) {
                                if ($request->status == 'jurnal' || ($request->akun == $valSharing->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Sharing Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valSharing->m_rekening_code,
                                        'akun' => $valSharing->m_rekening_nama,
                                        'particul' => 'pajak ojol (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-sharing'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-pajak'} != 0) {
                            foreach ($pajak as $valPajak) {
                                if ($request->status == 'jurnal' || ($request->akun == $valPajak->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pajak Ditahan Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valPajak->m_rekening_code,
                                        'akun' => $valPajak->m_rekening_nama,
                                        'particul' => 'pajak penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-pajak'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->sc != 0) {
                            foreach ($sc as $valsc) {
                                if ($request->status == 'jurnal' || ($request->akun == $valsc->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['SC Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valsc->m_rekening_code,
                                        'akun' => $valsc->m_rekening_nama,
                                        'particul' => 'sc penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->sc),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->tarik != 0) {
                            foreach ($tarik as $valTarik) {
                                if ($request->status == 'jurnal' || ($request->akun == $valTarik->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Tarik Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valTarik->m_rekening_code,
                                        'akun' => $valTarik->m_rekening_nama,
                                        'particul' => 'tarik tunai (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->tarik),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->pembulatan != 0) {
                            foreach ($bulat as $valBulat) {
                                if ($request->status == 'jurnal' || ($request->akun == $valBulat->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pembulatan Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valBulat->m_rekening_code,
                                        'akun' => $valBulat->m_rekening_nama,
                                        'particul' => 'pembulatan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->pembulatan),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->free != 0) {
                            foreach ($free as $valFree) {
                                if ($request->status == 'jurnal' || ($request->akun == $valFree->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['free Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valFree->m_rekening_code,
                                        'akun' => $valFree->m_rekening_nama,
                                        'particul' => 'free kembalian (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->free),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->diskon != 0) {
                            foreach ($diskon as $valDiskon) {
                                if ($request->status == 'jurnal' || ($request->akun == $valDiskon->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Diskon Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valDiskon->m_rekening_code,
                                        'akun' => $valDiskon->m_rekening_nama,
                                        'particul' => 'diskon penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->diskon),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-persediaan'} != 0) {
                            foreach ($persediaan as $valSedia) {
                                if ($request->status == 'jurnal' || ($request->akun == $valSedia->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Persediaan Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valSedia->m_rekening_code,
                                        'akun' => $valSedia->m_rekening_nama,
                                        'particul' => 'persediaan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-persediaan'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-persediaan'} != 0) {
                            foreach ($biaya_persediaan as $valBiayaSedia) {
                                if ($request->status == 'jurnal' || ($request->akun == $valBiayaSedia->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Biaya Persediaan Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valBiayaSedia->m_rekening_code,
                                        'akun' => $valBiayaSedia->m_rekening_nama,
                                        'particul' => 'biaya persediaan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-persediaan'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                    } elseif ($kasTrans->pay_method == 7) {
                        foreach ($ovo as $valKas) {
                            if ($request->status == 'jurnal' || ($request->akun == $valKas->m_rekening_code && $request->status == 'buku besar')) {
                                if (${$notaCode . '-menu'} != 0) {
                                    $data[$notaCode]['Ovo Menu'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'penjualan menu (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-menu'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-nonmenu'} != 0) {
                                    $data[$notaCode]['Ovo Non Menu'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'penjualan non menu (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-nonmenu'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-wbd'} != 0) {
                                    $data[$notaCode]['Ovo WBD'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'penjualan wbd (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-wbd'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-diluarusaha'} != 0) {
                                    $data[$notaCode]['Ovo Di luar Usaha'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'penjualan diluar usaha (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-diluarusaha'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-lainlain'} != 0) {
                                    $data[$notaCode]['Ovo Lain - Lain'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'pendapatan lain-lain (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-lainlain'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }

                                if (${$notaCode . '-sharing'} != 0) {
                                    $data[$notaCode]['Ovo Sharing'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'pajak ojol (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-sharing'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-pajak'} != 0) {
                                    $data[$notaCode]['Ovo Pajak'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'pajak penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-pajak'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->sc != 0) {
                                    $data[$notaCode]['Ovo SC'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'sc penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->sc),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->tarik != 0) {
                                    $data[$notaCode]['Ovo Tarik Tunai'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'tarik tunai (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->tarik),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->free != 0) {
                                    $data[$notaCode]['Ovo Free'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'free kembalian (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->free),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->pembulatan != 0) {
                                    $data[$notaCode]['Ovo Bulat'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'pembulatan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->pembulatan),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->diskon != 0) {
                                    $data[$notaCode]['Ovo Diskon'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'diskon penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->diskon),
                                        'urutan' => $urutan++,
                                    );
                                }
                            } //link ovo
                        }
                        if (${$notaCode . '-menu'} != 0) {
                            foreach ($nominal_menu as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Menu Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'penjualan menu (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-menu'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-nonmenu'} != 0) {
                            foreach ($nominal_non_menu as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Non Menu Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'penjualan non menu (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-nonmenu'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-wbd'} != 0) {
                            foreach ($nominal_WBD as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Wbd Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'penjualan wbd (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-wbd'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-diluarusaha'} != 0) {
                            foreach ($nominal_usaha as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Di luar Usaha Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'penjualan diluar usaha (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-diluarusaha'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-lainlain'} != 0) {
                            foreach ($nominal_lainlain as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Lain - Lain'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'pendapatan lain-lain (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-lainlain'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-sharing'} != 0) {
                            foreach ($nominal_tambahan_ojol as $valSharing) {
                                if ($request->status == 'jurnal' || ($request->akun == $valSharing->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Sharing Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valSharing->m_rekening_code,
                                        'akun' => $valSharing->m_rekening_nama,
                                        'particul' => 'pajak ojol (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-sharing'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-pajak'} != 0) {
                            foreach ($pajak as $valPajak) {
                                if ($request->status == 'jurnal' || ($request->akun == $valPajak->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pajak Ditahan Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valPajak->m_rekening_code,
                                        'akun' => $valPajak->m_rekening_nama,
                                        'particul' => 'pajak penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-pajak'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->sc != 0) {
                            foreach ($sc as $valsc) {
                                if ($request->status == 'jurnal' || ($request->akun == $valsc->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['SC Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valsc->m_rekening_code,
                                        'akun' => $valsc->m_rekening_nama,
                                        'particul' => 'sc penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->sc),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->tarik != 0) {
                            foreach ($tarik as $valTarik) {
                                if ($request->status == 'jurnal' || ($request->akun == $valTarik->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Tarik Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valTarik->m_rekening_code,
                                        'akun' => $valTarik->m_rekening_nama,
                                        'particul' => 'tarik tunai (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->tarik),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->pembulatan != 0) {
                            foreach ($bulat as $valBulat) {
                                if ($request->status == 'jurnal' || ($request->akun == $valBulat->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pembulatan Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valBulat->m_rekening_code,
                                        'akun' => $valBulat->m_rekening_nama,
                                        'particul' => 'pembulatan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->pembulatan),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->free != 0) {
                            foreach ($free as $valFree) {
                                if ($request->status == 'jurnal' || ($request->akun == $valFree->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['free Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valFree->m_rekening_code,
                                        'akun' => $valFree->m_rekening_nama,
                                        'particul' => 'free kembalian (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->free),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->diskon != 0) {
                            foreach ($diskon as $valDiskon) {
                                if ($request->status == 'jurnal' || ($request->akun == $valDiskon->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Diskon Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valDiskon->m_rekening_code,
                                        'akun' => $valDiskon->m_rekening_nama,
                                        'particul' => 'diskon penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->diskon),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-persediaan'} != 0) {
                            foreach ($persediaan as $valSedia) {
                                if ($request->status == 'jurnal' || ($request->akun == $valSedia->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Persediaan Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valSedia->m_rekening_code,
                                        'akun' => $valSedia->m_rekening_nama,
                                        'particul' => 'persediaan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-persediaan'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-persediaan'} != 0) {
                            foreach ($biaya_persediaan as $valBiayaSedia) {
                                if ($request->status == 'jurnal' || ($request->akun == $valBiayaSedia->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Biaya Persediaan Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valBiayaSedia->m_rekening_code,
                                        'akun' => $valBiayaSedia->m_rekening_nama,
                                        'particul' => 'biaya persediaan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-persediaan'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                    } elseif ($kasTrans->pay_method == 8) {
                        foreach ($shopee as $valKas) {
                            if ($request->status == 'jurnal' || ($request->akun == $valKas->m_rekening_code && $request->status == 'buku besar')) {
                                if (${$notaCode . '-menu'} != 0) {
                                    $data[$notaCode]['Shopee Menu'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'penjualan menu (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-menu'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-nonmenu'} != 0) {
                                    $data[$notaCode]['Shopee Non Menu'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'penjualan non menu (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-nonmenu'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-wbd'} != 0) {
                                    $data[$notaCode]['Shopee WBD'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'penjualan wbd (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-wbd'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-diluarusaha'} != 0) {
                                    $data[$notaCode]['Shopee Di luar Usaha'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'penjualan diluar usaha (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-diluarusaha'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-lainlain'} != 0) {
                                    $data[$notaCode]['Shopee Lain - Lain'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'pendapatan lain-lain (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-lainlain'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }

                                if (${$notaCode . '-sharing'} != 0) {
                                    $data[$notaCode]['Shopee Sharing'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'pajak ojol (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-sharing'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaCode . '-pajak'} != 0) {
                                    $data[$notaCode]['Shopee Pajak'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'pajak penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-pajak'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->sc != 0) {
                                    $data[$notaCode]['Shopee SC'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'sc penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->sc),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->tarik != 0) {
                                    $data[$notaCode]['Shopee Tarik Tunai'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'tarik tunai (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->tarik),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->free != 0) {
                                    $data[$notaCode]['Shopee Free'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'free kembalian (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->free),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->pembulatan != 0) {
                                    $data[$notaCode]['Shopee Bulat'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'pembulatan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->pembulatan),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($kasTrans->diskon != 0) {
                                    $data[$notaCode]['Shopee Diskon'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valKas->m_rekening_code,
                                        'akun' => $valKas->m_rekening_nama,
                                        'particul' => 'diskon penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->diskon),
                                        'urutan' => $urutan++,
                                    );
                                }
                            } //link shopee
                        }
                        if (${$notaCode . '-menu'} != 0) {
                            foreach ($nominal_menu as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Menu Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'penjualan menu (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-menu'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-nonmenu'} != 0) {
                            foreach ($nominal_non_menu as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Non Menu Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'penjualan non menu (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-nonmenu'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-wbd'} != 0) {
                            foreach ($nominal_WBD as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Wbd Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'penjualan wbd (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-wbd'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-diluarusaha'} != 0) {
                            foreach ($nominal_usaha as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Di luar Usaha Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'penjualan diluar usaha (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-diluarusaha'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-lainlain'} != 0) {
                            foreach ($nominal_lainlain as $valNominal) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNominal->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pendapatan Lain - Lain'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valNominal->m_rekening_code,
                                        'akun' => $valNominal->m_rekening_nama,
                                        'particul' => 'pendapatan lain-lain (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-lainlain'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-sharing'} != 0) {
                            foreach ($nominal_tambahan_ojol as $valSharing) {
                                if ($request->status == 'jurnal' || ($request->akun == $valSharing->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Sharing Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valSharing->m_rekening_code,
                                        'akun' => $valSharing->m_rekening_nama,
                                        'particul' => 'pajak ojol (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-sharing'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-pajak'} != 0) {
                            foreach ($pajak as $valPajak) {
                                if ($request->status == 'jurnal' || ($request->akun == $valPajak->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pajak Ditahan Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valPajak->m_rekening_code,
                                        'akun' => $valPajak->m_rekening_nama,
                                        'particul' => 'pajak penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-pajak'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->sc != 0) {
                            foreach ($sc as $valsc) {
                                if ($request->status == 'jurnal' || ($request->akun == $valsc->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['SC Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valsc->m_rekening_code,
                                        'akun' => $valsc->m_rekening_nama,
                                        'particul' => 'sc penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($kasTrans->sc),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->tarik != 0) {
                            foreach ($tarik as $valTarik) {
                                if ($request->status == 'jurnal' || ($request->akun == $valTarik->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Tarik Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valTarik->m_rekening_code,
                                        'akun' => $valTarik->m_rekening_nama,
                                        'particul' => 'tarik tunai (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->tarik),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->pembulatan != 0) {
                            foreach ($bulat as $valBulat) {
                                if ($request->status == 'jurnal' || ($request->akun == $valBulat->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Pembulatan Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valBulat->m_rekening_code,
                                        'akun' => $valBulat->m_rekening_nama,
                                        'particul' => 'pembulatan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->pembulatan),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->free != 0) {
                            foreach ($free as $valFree) {
                                if ($request->status == 'jurnal' || ($request->akun == $valFree->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['free Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valFree->m_rekening_code,
                                        'akun' => $valFree->m_rekening_nama,
                                        'particul' => 'free kembalian (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->free),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($kasTrans->diskon != 0) {
                            foreach ($diskon as $valDiskon) {
                                if ($request->status == 'jurnal' || ($request->akun == $valDiskon->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Diskon Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valDiskon->m_rekening_code,
                                        'akun' => $valDiskon->m_rekening_nama,
                                        'particul' => 'diskon penjualan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format($kasTrans->diskon),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-persediaan'} != 0) {
                            foreach ($persediaan as $valSedia) {
                                if ($request->status == 'jurnal' || ($request->akun == $valSedia->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Persediaan Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valSedia->m_rekening_code,
                                        'akun' => $valSedia->m_rekening_nama,
                                        'particul' => 'persediaan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaCode . '-persediaan'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaCode . '-persediaan'} != 0) {
                            foreach ($biaya_persediaan as $valBiayaSedia) {
                                if ($request->status == 'jurnal' || ($request->akun == $valBiayaSedia->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaCode]['Biaya Persediaan Transaksi'] = array(
                                        'tanggal' => $kasTrans->r_t_tanggal,
                                        'no_akun' => $kasTrans->r_t_m_w_code . '.' . $valBiayaSedia->m_rekening_code,
                                        'akun' => $valBiayaSedia->m_rekening_nama,
                                        'particul' => 'biaya persediaan (nota ' . $kasTrans->r_t_nota_code . ') - sesi ' . $kasTrans->sesi,
                                        'debit' => number_format(${$notaCode . '-persediaan'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                    }

                } //if notacode
            } //transaksi
        } //notacode
        foreach ($listRefund as $key => $notaRefund) {
            ${$notaRefund . '-menu'} = 0;
            ${$notaRefund . '-nonmenu'} = 0;
            ${$notaRefund . '-wbd'} = 0;
            ${$notaRefund . '-diluarusaha'} = 0;
            ${$notaRefund . '-lainlain'} = 0;
            ${$notaRefund . '-sharing'} = 0;
            ${$notaRefund . '-pajak'} = 0;
            ${$notaRefund . '-biaya_refund'} = 0;
            ${$notaRefund . '-penjualan_refund'} = 0;
            ${$notaRefund . '-pajak_refund'} = 0;
            ${$notaRefund . '-persediaan_refund'} = 0;

            foreach ($refund as $valRefund) {
                if ($valRefund->kode_id == $notaRefund) {
                    if ($valRefund->r_r_tanggal == $valRefund->r_t_tanggal) {
                        $listAll = array_merge($listMenu, $listNonMenu, $listWbd, $diLuarUsaha);
                        if (in_array($valRefund->produk_id, $listMenu)) {
                            $nominal = $valRefund->nominal;
                            ${$notaRefund . '-menu'} = $nominal;
                        }
                        if (in_array($valRefund->produk_id, $listNonMenu)) {
                            $nominal = $valRefund->nominal;
                            ${$notaRefund . '-nonmenu'} = $nominal;
                        }
                        if (in_array($valRefund->produk_id, $listWbd)) {
                            $nominal = $valRefund->nominal;
                            ${$notaRefund . '-wbd'} = $nominal;
                        }
                        if (in_array($valRefund->produk_id, $diLuarUsaha)) {
                            $nominal = $valRefund->nominal;
                            ${$notaRefund . '-diluarusaha'} = $nominal;
                        }
                        if (in_array($valRefund->produk_id, $lainLain)) {
                            $nominal = $valRefund->nominal;
                            ${$notaRefund . '-lainlain'} = $nominal;
                        }
                        if (in_array($valRefund->produk_id, $listAll)) {
                            $nominal = $valRefund->nominal * 0.1;
                            ${$notaRefund . '-sharing'} += $nominal;
                        }
                        if (in_array($valRefund->type_trans, [1, 2])) {
                            $nominal = $valRefund->pajak;
                            ${$notaRefund . '-pajak'} = $nominal;
                        }

                        foreach ($kas_refund as $valKasRefund) {
                            if ($request->status == 'jurnal' || ($request->akun == $valKasRefund->m_rekening_code && $request->status == 'buku besar')) {
                                if (${$notaRefund . '-menu'} != 0) {
                                    $data[$notaRefund]['Refund Kas Menu'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $valKasRefund->m_rekening_code,
                                        'akun' => $valKasRefund->m_rekening_nama,
                                        'particul' => 'refund menu (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaRefund . '-menu'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaRefund . '-nonmenu'} != 0) {
                                    $data[$notaRefund]['Refund Kas Non Menu'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $valKasRefund->m_rekening_code,
                                        'akun' => $valKasRefund->m_rekening_nama,
                                        'particul' => 'refund non menu (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaRefund . '-nonmenu'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaRefund . '-wbd'} != 0) {
                                    $data[$notaRefund]['Refund Kas Wbd'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $valKasRefund->m_rekening_code,
                                        'akun' => $valKasRefund->m_rekening_nama,
                                        'particul' => 'refund wbd (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaRefund . '-wbd'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaRefund . '-diluarusaha'} != 0) {
                                    $data[$notaRefund]['Refund Kas Di luar Usaha'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $valKasRefund->m_rekening_code,
                                        'akun' => $valKasRefund->m_rekening_nama,
                                        'particul' => 'refund diluar usaha (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaRefund . '-diluarusaha'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaRefund . '-lainlain'} != 0) {
                                    $data[$notaRefund]['Refund Lain - Lain'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $valKasRefund->m_rekening_code,
                                        'akun' => $valKasRefund->m_rekening_nama,
                                        'particul' => 'refund lain - lain (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaRefund . '-lainlain'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaRefund . '-sharing'} != 0) {
                                    $data[$notaRefund]['Refund Kas Sharing'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $valKasRefund->m_rekening_code,
                                        'akun' => $valKasRefund->m_rekening_nama,
                                        'particul' => 'pajak ojol refund (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaRefund . '-sharing'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaRefund . '-pajak'} != 0) {
                                    $data[$notaRefund]['Refund Kas Pajak'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $valKasRefund->m_rekening_code,
                                        'akun' => $valKasRefund->m_rekening_nama,
                                        'particul' => 'pajak refund (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaRefund . '-pajak'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($valRefund->sc != 0) {
                                    $data[$notaRefund]['Refund Kas SC'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $valKasRefund->m_rekening_code,
                                        'akun' => $valKasRefund->m_rekening_nama,
                                        'particul' => 'sc refund (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($valRefund->sc),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($valRefund->pembulatan != 0) {
                                    $data[$notaRefund]['Refund Kas Pembulatan'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $valKasRefund->m_rekening_code,
                                        'akun' => $valKasRefund->m_rekening_nama,
                                        'particul' => 'pembulatan refund (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($valRefund->pembulatan),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if ($valRefund->free != 0) {
                                    $data[$notaRefund]['Refund Kas Free'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $valKasRefund->m_rekening_code,
                                        'akun' => $valKasRefund->m_rekening_nama,
                                        'particul' => 'free kembali refund (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($valRefund->free),
                                        'urutan' => $urutan++,
                                    );
                                }
                            } //kas refund
                        }
                        if (${$notaRefund . '-menu'} != 0) {
                            foreach ($nominal_menu_refund as $ValMenuRefund) {
                                if ($request->status == 'jurnal' || ($request->akun == $ValMenuRefund->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaRefund]['Refund Menu'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $ValMenuRefund->m_rekening_code,
                                        'akun' => $ValMenuRefund->m_rekening_nama,
                                        'particul' => 'refund menu (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => number_format(${$notaRefund . '-menu'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaRefund . '-nonmenu'} != 0) {
                            foreach ($nominal_non_menu_refund as $ValMenuRefund) {
                                if ($request->status == 'jurnal' || ($request->akun == $ValMenuRefund->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaRefund]['Refund Non Menu'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $ValMenuRefund->m_rekening_code,
                                        'akun' => $ValMenuRefund->m_rekening_nama,
                                        'particul' => 'refund non menu (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => number_format(${$notaRefund . '-nonmenu'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaRefund . '-wbd'} != 0) {
                            foreach ($nominal_wbd_refund as $ValMenuRefund) {
                                if ($request->status == 'jurnal' || ($request->akun == $ValMenuRefund->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaRefund]['Refund Wbd'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $ValMenuRefund->m_rekening_code,
                                        'akun' => $ValMenuRefund->m_rekening_nama,
                                        'particul' => 'refund wbd (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => number_format(${$notaRefund . '-wbd'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaRefund . '-diluarusaha'} != 0) {
                            foreach ($nominal_usaha_refund as $ValMenuRefund) {
                                if ($request->status == 'jurnal' || ($request->akun == $ValMenuRefund->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaRefund]['Refund Di luar Usaha'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $ValMenuRefund->m_rekening_code,
                                        'akun' => $ValMenuRefund->m_rekening_nama,
                                        'particul' => 'refund diluar usaha (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => number_format(${$notaRefund . '-diluarusaha'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaRefund . '-lainlain'} != 0) {
                            foreach ($nominal_lainlain_refund as $ValMenuRefund) {
                                if ($request->status == 'jurnal' || ($request->akun == $ValMenuRefund->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaRefund]['Refund Lain - Lain'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $ValMenuRefund->m_rekening_code,
                                        'akun' => $ValMenuRefund->m_rekening_nama,
                                        'particul' => 'refund lain - lain (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => number_format(${$notaRefund . '-lainlain'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaRefund . '-sharing'} != 0) {
                            foreach ($nominal_tambahan_ojol as $valSharing) {
                                if ($request->status == 'jurnal' || ($request->akun == $valSharing->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaRefund]['Refund Sharing'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $valSharing->m_rekening_code,
                                        'akun' => $valSharing->m_rekening_nama,
                                        'particul' => 'pajak ojol refund (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => number_format(${$notaRefund . '-sharing'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaRefund . '-pajak'} != 0) {
                            foreach ($pajak_refund as $valPajakRef) {
                                if ($request->status == 'jurnal' || ($request->akun == $valPajakRef->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaRefund]['Refund Pajak'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $valPajakRef->m_rekening_code,
                                        'akun' => $valPajakRef->m_rekening_nama,
                                        'particul' => 'pajak refund (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => number_format(${$notaRefund . '-pajak'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($valRefund->sc != 0) {
                            foreach ($sc_refund as $valScRef) {
                                if ($request->status == 'jurnal' || ($request->akun == $valScRef->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaRefund]['Refund SC'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $valScRef->m_rekening_code,
                                        'akun' => $valScRef->m_rekening_nama,
                                        'particul' => 'sc refund (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => number_format($valRefund->sc),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($valRefund->pembulatan != 0) {
                            foreach ($bulat_refund as $valBulatRef) {
                                if ($request->status == 'jurnal' || ($request->akun == $valBulatRef->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaRefund]['Refund Pembulatan'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $valBulatRef->m_rekening_code,
                                        'akun' => $valBulatRef->m_rekening_nama,
                                        'particul' => 'pembulatan refund (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => number_format($valRefund->pembulatan),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($valRefund->free != 0) {
                            foreach ($free_refund as $valFreeRef) {
                                if ($request->status == 'jurnal' || ($request->akun == $valFreeRef->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaRefund]['Refund Free'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $valFreeRef->m_rekening_code,
                                        'akun' => $valFreeRef->m_rekening_nama,
                                        'particul' => 'free kembalian refund (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => number_format($valRefund->free),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($valRefund->nominal != 0) {
                            foreach ($sedia_refund as $valSediaRef) {
                                if ($request->status == 'jurnal' || ($request->akun == $valSediaRef->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaRefund]['Refund Persediaan'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $valSediaRef->m_rekening_code,
                                        'akun' => $valSediaRef->m_rekening_nama,
                                        'particul' => 'persediaan refund (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => number_format($valRefund->nominal * 0.8),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($valRefund->nominal != 0) {
                            foreach ($biaya_sedia_refund as $valBiayaSediaRef) {
                                if ($request->status == 'jurnal' || ($request->akun == $valBiayaSediaRef->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaRefund]['Refund Biaya Persediaan'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $valBiayaSediaRef->m_rekening_code,
                                        'akun' => $valBiayaSediaRef->m_rekening_nama,
                                        'particul' => 'biaya persediaan refund (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($valRefund->nominal * 0.8),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                    } elseif ($valRefund->r_r_tanggal != $valRefund->r_t_tanggal) {
                        $listAll = array_merge($listMenu, $listNonMenu, $listWbd, $diLuarUsaha);
                        if (in_array($valRefund->produk_id, $listAll) && in_array($valRefund->type_trans, [1, 2])) {
                            $nominal = $valRefund->nominal + $valRefund->pajak;
                            ${$notaRefund . '-biaya_refund'} += $nominal;
                        }
                        if (in_array($valRefund->produk_id, $listMenu)) {
                            $nominal = $valRefund->nominal;
                            ${$notaRefund . '-menu'} += $nominal;
                        }
                        if (in_array($valRefund->produk_id, $listNonMenu)) {
                            $nominal = $valRefund->nominal;
                            ${$notaRefund . '-nonmenu'} += $nominal;
                        }
                        if (in_array($valRefund->produk_id, $listWbd)) {
                            $nominal = $valRefund->nominal;
                            ${$notaRefund . '-wbd'} += $nominal;
                        }
                        if (in_array($valRefund->produk_id, $diLuarUsaha)) {
                            $nominal = $valRefund->nominal;
                            ${$notaRefund . '-diluarusaha'} += $nominal;
                        }
                        if (in_array($valRefund->produk_id, $lainLain)) {
                            $nominal = $valRefund->nominal;
                            ${$notaRefund . '-lainlain'} += $nominal;
                        }
                        if (in_array($valRefund->type_trans, [1, 2])) {
                            $nominal = $valRefund->pajak;
                            ${$notaRefund . '-pajak_refund'} += $nominal;
                        }

                        if (${$notaRefund . '-biaya_refund'} != 0) {
                            foreach ($biaya_refund as $ValMenuRefund) {
                                if ($request->status == 'jurnal' || ($request->akun == $ValMenuRefund->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaRefund]['Refund Dif Biaya'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $ValMenuRefund->m_rekening_code,
                                        'akun' => $ValMenuRefund->m_rekening_nama,
                                        'particul' => 'biaya refund (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => number_format(${$notaRefund . '-biaya_refund'}),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        foreach ($kas_refund as $ValMenuRefund) {
                            if ($request->status == 'jurnal' || ($request->akun == $ValMenuRefund->m_rekening_code && $request->status == 'buku besar')) {
                                if (${$notaRefund . '-menu'} != 0) {
                                    $data[$notaRefund]['Refund Dif Kas Penjualan Menu'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $ValMenuRefund->m_rekening_code,
                                        'akun' => $ValMenuRefund->m_rekening_nama,
                                        'particul' => 'refund menu (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaRefund . '-menu'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaRefund . '-nonmenu'} != 0) {
                                    $data[$notaRefund]['Refund Dif Kas Penjualan Non Menu'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $ValMenuRefund->m_rekening_code,
                                        'akun' => $ValMenuRefund->m_rekening_nama,
                                        'particul' => 'refund non menu (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaRefund . '-nonmenu'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaRefund . '-wbd'} != 0) {
                                    $data[$notaRefund]['Refund Dif Kas Penjualan WBD'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $ValMenuRefund->m_rekening_code,
                                        'akun' => $ValMenuRefund->m_rekening_nama,
                                        'particul' => 'refund wbd (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaRefund . '-wbd'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaRefund . '-diluarusaha'} != 0) {
                                    $data[$notaRefund]['Refund Dif Kas Penjualan Diluar Usaha'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $ValMenuRefund->m_rekening_code,
                                        'akun' => $ValMenuRefund->m_rekening_nama,
                                        'particul' => 'refund diluar usaha (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaRefund . '-diluarusaha'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                                if (${$notaRefund . '-lainlain'} != 0) {
                                    $data[$notaRefund]['Refund Dif Kas Penjualan Lain - Lain'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $ValMenuRefund->m_rekening_code,
                                        'akun' => $ValMenuRefund->m_rekening_nama,
                                        'particul' => 'refund lain - lain (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaRefund . '-lainlain'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if (${$notaRefund . '-pajak_refund'} != 0) {
                            foreach ($pajak_refund as $ValMenuRefund) {
                                if ($request->status == 'jurnal' || ($request->akun == $ValMenuRefund->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaRefund]['Refund Dif Pajak'] = array(
                                        'tanggal' => $valRefund->r_r_tanggal,
                                        'no_akun' => $valRefund->r_r_m_w_code . '.' . $ValMenuRefund->m_rekening_code,
                                        'akun' => $ValMenuRefund->m_rekening_nama,
                                        'particul' => 'pajak refund (nota ' . $valRefund->r_r_nota_code . ') - sesi ' . $valRefund->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format(${$notaRefund . '-pajak_refund'}),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                    }
                } //if notacode
            } //refund
        } //nota code
        foreach ($listLostbill as $key => $notaLostbill) {
            ${$notaLostbill . '-menu'} = 0;
            ${$notaLostbill . '-nonmenu'} = 0;
            ${$notaLostbill . '-wbd'} = 0;
            ${$notaLostbill . '-diluarusaha'} = 0;
            ${$notaLostbill . '-lainlain'} = 0;
            ${$notaLostbill . '-pajak'} = 0;
            ${$notaLostbill . '-biaya_lostbill'} = 0;
            ${$notaLostbill . '-pajak_lostbill'} = 0;
            ${$notaLostbill . '-persediaan_lostbill'} = 0;
            foreach ($lostbill as $keyLost => $valLostbill) {
                if ($valLostbill->kode_id == $notaLostbill) {
                    $listAll = array_merge($listMenu, $listNonMenu, $listWbd, $diLuarUsaha);
                    if (in_array($valLostbill->produk_id, $listMenu)) {
                        $nominal = $valLostbill->nominal;
                        ${$notaLostbill . '-menu'} += $nominal;
                    }
                    if (in_array($valLostbill->produk_id, $listNonMenu)) {
                        $nominal = $valLostbill->nominal;
                        ${$notaLostbill . '-nonmenu'} += $nominal;
                    }
                    if (in_array($valLostbill->produk_id, $listWbd)) {
                        $nominal = $valLostbill->nominal;
                        ${$notaLostbill . '-wbd'} += $nominal;
                    }
                    if (in_array($valLostbill->produk_id, $diLuarUsaha)) {
                        $nominal = $valLostbill->nominal;
                        ${$notaLostbill . '-diluarusaha'} += $nominal;
                    }
                    if (in_array($valLostbill->produk_id, $lainLain)) {
                        $nominal = $valLostbill->nominal;
                        ${$notaLostbill . '-lainlain'} += $nominal;
                    }
                    if (in_array($valLostbill->produk_id, $listAll) && in_array($valLostbill->type_trans, [1, 2])) {
                        $nominal = $valLostbill->nominal + $valLostbill->pajak;
                        ${$notaLostbill . '-biaya_lostbill'} += $nominal;
                    }
                    if (in_array($valLostbill->type_trans, [1, 2])) {
                        $nominal = $valLostbill->pajak;
                        ${$notaLostbill . '-pajak_lostbill'} += $nominal;
                    }
                    if (in_array($valLostbill->produk_id, $listAll)) {
                        $nominal = $valLostbill->nominal * 0.8;
                        ${$notaLostbill . '-persediaan_lostbill'} += $nominal;
                    }
                    if (${$notaLostbill . '-biaya_lostbill'} != 0) {
                        foreach ($biaya_lostbill as $ValMenuLostbill) {
                            if ($request->status == 'jurnal' || ($request->akun == $ValMenuLostbill->m_rekening_code && $request->status == 'buku besar')) {
                                $data[$notaLostbill]['Lostbill Biaya'] = array(
                                    'tanggal' => $valLostbill->r_t_tanggal,
                                    'no_akun' => $valLostbill->r_t_m_w_code . '.' . $ValMenuLostbill->m_rekening_code,
                                    'akun' => $ValMenuLostbill->m_rekening_nama,
                                    'particul' => 'biaya lostbill (nota ' . $valLostbill->r_t_nota_code . ') - sesi ' . $valLostbill->sesi,
                                    'debit' => number_format(${$notaLostbill . '-biaya_lostbill'}),
                                    'kredit' => 0,
                                    'urutan' => $urutan++,
                                );
                            }
                        }
                    }
                    foreach ($penjualan_lostbill as $ValMenuLostbill) {
                        if ($request->status == 'jurnal' || ($request->akun == $ValMenuLostbill->m_rekening_code && $request->status == 'buku besar')) {
                            if (${$notaLostbill . '-menu'} != 0) {
                                $data[$notaLostbill]['Lostbill Menu'] = array(
                                    'tanggal' => $valLostbill->r_t_tanggal,
                                    'no_akun' => $valLostbill->r_t_m_w_code . '.' . $ValMenuLostbill->m_rekening_code,
                                    'akun' => $ValMenuLostbill->m_rekening_nama,
                                    'particul' => 'menu lostbill (nota ' . $valLostbill->r_t_nota_code . ') - sesi ' . $valLostbill->sesi,
                                    'debit' => 0,
                                    'kredit' => number_format(${$notaLostbill . '-menu'}),
                                    'urutan' => $urutan++,
                                );
                            }
                            if (${$notaLostbill . '-nonmenu'} != 0) {
                                $data[$notaLostbill]['Lostbill Non Menu'] = array(
                                    'tanggal' => $valLostbill->r_t_tanggal,
                                    'no_akun' => $valLostbill->r_t_m_w_code . '.' . $ValMenuLostbill->m_rekening_code,
                                    'akun' => $ValMenuLostbill->m_rekening_nama,
                                    'particul' => 'non menu lostbill (nota ' . $valLostbill->r_t_nota_code . ') - sesi ' . $valLostbill->sesi,
                                    'debit' => 0,
                                    'kredit' => number_format(${$notaLostbill . '-nonmenu'}),
                                    'urutan' => $urutan++,
                                );
                            }
                            if (${$notaLostbill . '-wbd'} != 0) {
                                $data[$notaLostbill]['Lostbill Wbd'] = array(
                                    'tanggal' => $valLostbill->r_t_tanggal,
                                    'no_akun' => $valLostbill->r_t_m_w_code . '.' . $ValMenuLostbill->m_rekening_code,
                                    'akun' => $ValMenuLostbill->m_rekening_nama,
                                    'particul' => 'penjualan wbd (nota ' . $valLostbill->r_t_nota_code . ') - sesi ' . $valLostbill->sesi,
                                    'debit' => 0,
                                    'kredit' => number_format(${$notaLostbill . '-wbd'}),
                                    'urutan' => $urutan++,
                                );
                            }
                            if (${$notaLostbill . '-diluarusaha'} != 0) {
                                $data[$notaLostbill]['Lostbill Di luar Usaha'] = array(
                                    'tanggal' => $valLostbill->r_t_tanggal,
                                    'no_akun' => $valLostbill->r_t_m_w_code . '.' . $ValMenuLostbill->m_rekening_code,
                                    'akun' => $ValMenuLostbill->m_rekening_nama,
                                    'particul' => 'penjualan diluar usaha (nota ' . $valLostbill->r_t_nota_code . ') - sesi ' . $valLostbill->sesi,
                                    'debit' => 0,
                                    'kredit' => number_format(${$notaLostbill . '-diluarusaha'}),
                                    'urutan' => $urutan++,
                                );
                            }
                            if (${$notaLostbill . '-lainlain'} != 0) {
                                $data[$notaLostbill]['Lostbill Lain - Lain'] = array(
                                    'tanggal' => $valLostbill->r_t_tanggal,
                                    'no_akun' => $valLostbill->r_t_m_w_code . '.' . $ValMenuLostbill->m_rekening_code,
                                    'akun' => $ValMenuLostbill->m_rekening_nama,
                                    'particul' => 'penjualan lain - lain (nota ' . $valLostbill->r_t_nota_code . ') - sesi ' . $valLostbill->sesi,
                                    'debit' => 0,
                                    'kredit' => number_format(${$notaLostbill . '-lainlain'}),
                                    'urutan' => $urutan++,
                                );
                            }
                        }
                    }
                    if (${$notaLostbill . '-pajak_lostbill'} != 0) {
                        foreach ($pajak_lostbill as $ValMenuLostbill) {
                            if ($request->status == 'jurnal' || ($request->akun == $ValMenuLostbill->m_rekening_code && $request->status == 'buku besar')) {
                                $data[$notaLostbill]['Lostbill Pajak'] = array(
                                    'tanggal' => $valLostbill->r_t_tanggal,
                                    'no_akun' => $valLostbill->r_t_m_w_code . '.' . $ValMenuLostbill->m_rekening_code,
                                    'akun' => $ValMenuLostbill->m_rekening_nama,
                                    'particul' => 'pajak lostbill (nota ' . $valLostbill->r_t_nota_code . ') - sesi ' . $valLostbill->sesi,
                                    'debit' => 0,
                                    'kredit' => number_format(${$notaLostbill . '-pajak_lostbill'}),
                                    'urutan' => $urutan++,
                                );
                            }
                        }
                    }
                    if (${$notaLostbill . '-persediaan_lostbill'} != 0) {
                        foreach ($sedia_lostbill as $ValMenuLostbill) {
                            if ($request->status == 'jurnal' || ($request->akun == $ValMenuLostbill->m_rekening_code && $request->status == 'buku besar')) {
                                $data[$notaLostbill]['Lostbill Persediaan'] = array(
                                    'tanggal' => $valLostbill->r_t_tanggal,
                                    'no_akun' => $valLostbill->r_t_m_w_code . '.' . $ValMenuLostbill->m_rekening_code,
                                    'akun' => $ValMenuLostbill->m_rekening_nama,
                                    'particul' => 'persediaan lostbill (nota ' . $valLostbill->r_t_nota_code . ') - sesi ' . $valLostbill->sesi,
                                    'debit' => 0,
                                    'kredit' => number_format(${$notaLostbill . '-persediaan_lostbill'}),
                                    'urutan' => $urutan++,
                                );
                            }
                        }
                    }
                    if (${$notaLostbill . '-persediaan_lostbill'} != 0) {
                        foreach ($biaya_sedia_lostbill as $ValMenuLostbill) {
                            if ($request->status == 'jurnal' || ($request->akun == $ValMenuLostbill->m_rekening_code && $request->status == 'buku besar')) {
                                $data[$notaLostbill]['Lostbill Biaya Persediaan'] = array(
                                    'tanggal' => $valLostbill->r_t_tanggal,
                                    'no_akun' => $valLostbill->r_t_m_w_code . '.' . $ValMenuLostbill->m_rekening_code,
                                    'akun' => $ValMenuLostbill->m_rekening_nama,
                                    'particul' => 'biaya persediaan lostbill (nota ' . $valLostbill->r_t_nota_code . ') - sesi ' . $valLostbill->sesi,
                                    'debit' => number_format(${$notaLostbill . '-persediaan_lostbill'}),
                                    'kredit' => 0,
                                    'urutan' => $urutan++,
                                );
                            }
                        }
                    }
                } //if notacode
            } //lostbill
        } //nota code
        foreach ($listGaransi as $key => $notaGaransi) {
            ${$notaGaransi . '-menu'} = 0;
            ${$notaGaransi . '-nonmenu'} = 0;
            ${$notaGaransi . '-wbd'} = 0;
            ${$notaGaransi . '-diluarusaha'} = 0;
            ${$notaGaransi . '-lainlain'} = 0;
            ${$notaGaransi . '-pajak'} = 0;
            ${$notaGaransi . '-biaya'} = 0;
            ${$notaGaransi . '-persediaan'} = 0;
            foreach ($garansi as $keyGaransi => $valGaransi) {
                if ($valGaransi->kode_id == $notaGaransi) {
                    $listAll = array_merge($listMenu, $listNonMenu, $listWbd, $diLuarUsaha);
                    if (in_array($valGaransi->produk_id, $listMenu)) {
                        $nominal = $valGaransi->nominal;
                        ${$notaGaransi . '-menu'} += $nominal;
                    }
                    if (in_array($valGaransi->produk_id, $listNonMenu)) {
                        $nominal = $valGaransi->nominal;
                        ${$notaGaransi . '-nonmenu'} += $nominal;
                    }
                    if (in_array($valGaransi->produk_id, $listWbd)) {
                        $nominal = $valGaransi->nominal;
                        ${$notaGaransi . '-wbd'} += $nominal;
                    }
                    if (in_array($valGaransi->produk_id, $diLuarUsaha)) {
                        $nominal = $valGaransi->nominal;
                        ${$notaGaransi . '-diluarusaha'} += $nominal;
                    }
                    if (in_array($valGaransi->produk_id, $lainLain)) {
                        $nominal = $valGaransi->nominal;
                        ${$notaGaransi . '-lainlain'} += $nominal;
                    }
                    if (in_array($valGaransi->produk_id, $listAll)) {
                        $nominal = $valGaransi->nominal;
                        ${$notaGaransi . '-biaya'} += $nominal;
                    }
                    if (in_array($valGaransi->produk_id, $listAll)) {
                        $nominal = $valGaransi->nominal * 0.8;
                        ${$notaGaransi . '-persediaan'} += $nominal;
                    }
                    if (${$notaGaransi . '-biaya'} != 0) {
                        foreach ($biaya_garansi as $ValMenuGaransi) {
                            if ($request->status == 'jurnal' || ($request->akun == $ValMenuGaransi->m_rekening_code && $request->status == 'buku besar')) {
                                $data[$notaGaransi]['Garansi Biaya'] = array(
                                    'tanggal' => $valGaransi->r_t_tanggal,
                                    'no_akun' => $valGaransi->r_t_m_w_code . '.' . $ValMenuGaransi->m_rekening_code,
                                    'akun' => $ValMenuGaransi->m_rekening_nama,
                                    'particul' => 'biaya garansi (nota ' . $valGaransi->r_t_nota_code . ') - sesi ' . $valGaransi->sesi,
                                    'debit' => number_format(${$notaGaransi . '-biaya'}),
                                    'kredit' => 0,
                                    'urutan' => $urutan++,
                                );
                            }
                        }
                    }
                    foreach ($penjualan_garansi as $ValMenuGaransi) {
                        if ($request->status == 'jurnal' || ($request->akun == $ValMenuGaransi->m_rekening_code && $request->status == 'buku besar')) {
                            if (${$notaGaransi . '-menu'} != 0) {
                                $data[$notaGaransi]['Garansi Menu'] = array(
                                    'tanggal' => $valGaransi->r_t_tanggal,
                                    'no_akun' => $valGaransi->r_t_m_w_code . '.' . $ValMenuGaransi->m_rekening_code,
                                    'akun' => $ValMenuGaransi->m_rekening_nama,
                                    'particul' => 'garansi menu (cat : ' . $valGaransi->catatan . ' (nota ' . $valGaransi->r_t_nota_code . ') - sesi ' . $valGaransi->sesi,
                                    'debit' => 0,
                                    'kredit' => number_format(${$notaGaransi . '-menu'}),
                                    'urutan' => $urutan++,
                                );
                            }
                            if (${$notaGaransi . '-nonmenu'} != 0) {
                                $data[$notaGaransi]['Garansi Non Menu'] = array(
                                    'tanggal' => $valGaransi->r_t_tanggal,
                                    'no_akun' => $valGaransi->r_t_m_w_code . '.' . $ValMenuGaransi->m_rekening_code,
                                    'akun' => $ValMenuGaransi->m_rekening_nama,
                                    'particul' => 'garansi non menu (cat : ' . $valGaransi->catatan . ' (nota ' . $valGaransi->r_t_nota_code . ') - sesi ' . $valGaransi->sesi,
                                    'debit' => 0,
                                    'kredit' => number_format(${$notaGaransi . '-nonmenu'}),
                                    'urutan' => $urutan++,
                                );
                            }
                            if (${$notaGaransi . '-wbd'} != 0) {
                                $data[$notaGaransi]['Garansi Wbd'] = array(
                                    'tanggal' => $valGaransi->r_t_tanggal,
                                    'no_akun' => $valGaransi->r_t_m_w_code . '.' . $ValMenuGaransi->m_rekening_code,
                                    'akun' => $ValMenuGaransi->m_rekening_nama,
                                    'particul' => 'garansi wbd (cat : ' . $valGaransi->catatan . ' (nota ' . $valGaransi->r_t_nota_code . ') - sesi ' . $valGaransi->sesi,
                                    'debit' => 0,
                                    'kredit' => number_format(${$notaGaransi . '-wbd'}),
                                    'urutan' => $urutan++,
                                );
                            }
                            if (${$notaGaransi . '-diluarusaha'} != 0) {
                                $data[$notaGaransi]['Garansi Di luar Usaha'] = array(
                                    'tanggal' => $valGaransi->r_t_tanggal,
                                    'no_akun' => $valGaransi->r_t_m_w_code . '.' . $ValMenuGaransi->m_rekening_code,
                                    'akun' => $ValMenuGaransi->m_rekening_nama,
                                    'particul' => 'garansi diluar usaha (cat : ' . $valGaransi->catatan . ' (nota ' . $valGaransi->r_t_nota_code . ') - sesi ' . $valGaransi->sesi,
                                    'debit' => 0,
                                    'kredit' => number_format(${$notaGaransi . '-diluarusaha'}),
                                    'urutan' => $urutan++,
                                );
                            }
                            if (${$notaGaransi . '-lainlain'} != 0) {
                                $data[$notaGaransi]['Garansi Lain - Lain'] = array(
                                    'tanggal' => $valGaransi->r_t_tanggal,
                                    'no_akun' => $valGaransi->r_t_m_w_code . '.' . $ValMenuGaransi->m_rekening_code,
                                    'akun' => $ValMenuGaransi->m_rekening_nama,
                                    'particul' => 'garansi lain - lain (cat : ' . $valGaransi->catatan . ' (nota ' . $valGaransi->r_t_nota_code . ') - sesi ' . $valGaransi->sesi,
                                    'debit' => 0,
                                    'kredit' => number_format(${$notaGaransi . '-lainlain'}),
                                    'urutan' => $urutan++,
                                );
                            }
                        }
                    }
                    if (${$notaGaransi . '-persediaan'} != 0) {
                        foreach ($sedia_garansi as $ValMenuGaransi) {
                            if ($request->status == 'jurnal' || ($request->akun == $ValMenuGaransi->m_rekening_code && $request->status == 'buku besar')) {
                                $data[$notaGaransi]['Garansi Persediaan'] = array(
                                    'tanggal' => $valGaransi->r_t_tanggal,
                                    'no_akun' => $valGaransi->r_t_m_w_code . '.' . $ValMenuGaransi->m_rekening_code,
                                    'akun' => $ValMenuGaransi->m_rekening_nama,
                                    'particul' => 'persediaan garansi (nota ' . $valGaransi->r_t_nota_code . ') - sesi ' . $valGaransi->sesi,
                                    'debit' => 0,
                                    'kredit' => number_format(${$notaGaransi . '-persediaan'}),
                                    'urutan' => $urutan++,
                                );
                            }
                        }
                    }
                    if (${$notaGaransi . '-persediaan'} != 0) {
                        foreach ($biaya_sedia_garansi as $ValMenuGaransi) {
                            if ($request->status == 'jurnal' || ($request->akun == $ValMenuGaransi->m_rekening_code && $request->status == 'buku besar')) {
                                $data[$notaGaransi]['Garansi Biaya Persediaan'] = array(
                                    'tanggal' => $valGaransi->r_t_tanggal,
                                    'no_akun' => $valGaransi->r_t_m_w_code . '.' . $ValMenuGaransi->m_rekening_code,
                                    'akun' => $ValMenuGaransi->m_rekening_nama,
                                    'particul' => 'biaya persediaan garansi (nota ' . $valGaransi->r_t_nota_code . ') - sesi ' . $valGaransi->sesi,
                                    'debit' => number_format(${$notaGaransi . '-persediaan'}),
                                    'kredit' => 0,
                                    'urutan' => $urutan++,
                                );
                            }
                        }
                    }
                } //if notacode
            } //garansi
        } //nota code
        foreach ($listMutasi as $key => $notaMutasi) {
            foreach ($mutasi as $keyMutasi => $valMutasi) {
                // $urutan = 1;
                if ($valMutasi->kode_id == $notaMutasi) {
                    if ($valMutasi->kredit != 0) {
                        if (stripos($valMutasi->catatan, 'reguler') !== false) {
                            foreach ($mutasi_keluar as $valNotaMutasi) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNotaMutasi->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaMutasi]['Mutasi Kasbon Keluar Reguler'] = array(
                                        'tanggal' => $valMutasi->tanggal,
                                        'no_akun' => $valMutasi->m_w_code . '.' . $valNotaMutasi->m_rekening_code,
                                        'akun' => $valNotaMutasi->m_rekening_nama,
                                        'particul' => 'mutasi kasbon keluar ' . $valMutasi->catatan . ' - sesi ' . $valMutasi->sesi,
                                        'debit' => number_format($valMutasi->kredit),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                            foreach ($kas_mutasi as $valNotaMutasi) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNotaMutasi->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaMutasi]['Mutasi kas Keluar Reguler'] = array(
                                        'tanggal' => $valMutasi->tanggal,
                                        'no_akun' => $valMutasi->m_w_code . '.' . $valNotaMutasi->m_rekening_code,
                                        'akun' => $valNotaMutasi->m_rekening_nama,
                                        'particul' => 'mutasi kas keluar ' . $valMutasi->catatan . ' - sesi ' . $valMutasi->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($valMutasi->kredit),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        } elseif (stripos($valMutasi->catatan, 'ojol') !== false) {
                            foreach ($mutasi_keluar_ojol as $valNotaMutasi) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNotaMutasi->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaMutasi]['Mutasi Kasbon Keluar Ojol'] = array(
                                        'tanggal' => $valMutasi->tanggal,
                                        'no_akun' => $valMutasi->m_w_code . '.' . $valNotaMutasi->m_rekening_code,
                                        'akun' => $valNotaMutasi->m_rekening_nama,
                                        'particul' => 'mutasi kasbon keluar  ' . $valMutasi->catatan . ' - sesi ' . $valMutasi->sesi,
                                        'debit' => number_format($valMutasi->kredit),
                                        'kredit' => 0,
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                            foreach ($kas_mutasi as $valNotaMutasi) {
                                if ($request->status == 'jurnal' || ($request->akun == $valNotaMutasi->m_rekening_code && $request->status == 'buku besar')) {
                                    $data[$notaMutasi]['Mutasi kas Keluar Ojol'] = array(
                                        'tanggal' => $valMutasi->tanggal,
                                        'no_akun' => $valMutasi->m_w_code . '.' . $valNotaMutasi->m_rekening_code,
                                        'akun' => $valNotaMutasi->m_rekening_nama,
                                        'particul' => 'mutasi kas keluar  ' . $valMutasi->catatan . ' - sesi ' . $valMutasi->sesi,
                                        'debit' => 0,
                                        'kredit' => number_format($valMutasi->kredit),
                                        'urutan' => $urutan++,
                                    );
                                }
                            }
                        }
                        if ($valMutasi->debit != 0) {
                            if (stripos($valMutasi->catatan, 'reguler') !== false) {
                                foreach ($kas_mutasi as $valNotaMutasi) {
                                    if ($request->status == 'jurnal' || ($request->akun == $valNotaMutasi->m_rekening_code && $request->status == 'buku besar')) {
                                        $data[$notaMutasi]['Mutasi Kas Masuk Reguler'] = array(
                                            'tanggal' => $valMutasi->tanggal,
                                            'no_akun' => $valMutasi->m_w_code . '.' . $valNotaMutasi->m_rekening_code,
                                            'akun' => $valNotaMutasi->m_rekening_nama,
                                            'particul' => 'mutasi kas masuk ' . $valMutasi->catatan . ' - sesi ' . $valMutasi->sesi,
                                            'debit' => 0,
                                            'kredit' => number_format($valMutasi->debit),
                                            'urutan' => $urutan++,
                                        );
                                    }
                                }
                                foreach ($mutasi_masuk as $valNotaMutasi) {
                                    if ($request->status == 'jurnal' || ($request->akun == $valNotaMutasi->m_rekening_code && $request->status == 'buku besar')) {
                                        $data[$notaMutasi]['Mutasi Kasbon Masuk Reguler'] = array(
                                            'tanggal' => $valMutasi->tanggal,
                                            'no_akun' => $valMutasi->m_w_code . '.' . $valNotaMutasi->m_rekening_code,
                                            'akun' => $valNotaMutasi->m_rekening_nama,
                                            'particul' => 'mutasi kasbon masuk ' . $valMutasi->catatan . ' - sesi ' . $valMutasi->sesi,
                                            'debit' => number_format($valMutasi->debit),
                                            'kredit' => 0,
                                            'urutan' => $urutan++,
                                        );
                                    }
                                }
                            } elseif (stripos($valMutasi->catatan, 'ojol') !== false) {
                                foreach ($kas_mutasi as $valNotaMutasi) {
                                    if ($request->status == 'jurnal' || ($request->akun == $valNotaMutasi->m_rekening_code && $request->status == 'buku besar')) {
                                        $data[$notaMutasi]['Mutasi Kas Masuk Ojol'] = array(
                                            'tanggal' => $valMutasi->tanggal,
                                            'no_akun' => $valMutasi->m_w_code . '.' . $valNotaMutasi->m_rekening_code,
                                            'akun' => $valNotaMutasi->m_rekening_nama,
                                            'particul' => 'mutasi kas masuk  ' . $valMutasi->catatan . ' - sesi ' . $valMutasi->sesi,
                                            'debit' => 0,
                                            'kredit' => number_format($valMutasi->debit),
                                            'urutan' => $urutan++,
                                        );
                                    }
                                }
                                foreach ($mutasi_masuk as $valNotaMutasi) {
                                    if ($request->status == 'jurnal' || ($request->akun == $valNotaMutasi->m_rekening_code && $request->status == 'buku besar')) {
                                        $data[$notaMutasi]['Mutasi Kasbon Masuk Ojol'] = array(
                                            'tanggal' => $valMutasi->tanggal,
                                            'no_akun' => $valMutasi->m_w_code . '.' . $valNotaMutasi->m_rekening_code,
                                            'akun' => $valNotaMutasi->m_rekening_nama,
                                            'particul' => 'mutasi kasbon masuk  ' . $valMutasi->catatan . ' - sesi ' . $valMutasi->sesi,
                                            'debit' => number_format($valMutasi->debit),
                                            'kredit' => 0,
                                            'urutan' => $urutan++,
                                        );
                                    }
                                }
                            }
                        }
                    } //if selisih not 0
                } //if notacode
            } //mutasi kasir
        } //nota code
        // foreach ($listSelisihKasir as $key => $notaSelisih) {
        //     foreach ($selisih as $keySelisih => $valSelisih) {
        //         if ($valSelisih->kode_id == $notaSelisih) {
        //             if ($valSelisih->nominal != 0) {
        //                 if ($valSelisih->nominal > 0) {
        //                     foreach ($selisih_kasir as $valNotaSelisih) {
        //                         $data[$notaSelisih]['Selisih Plus'] = array(
        //                             'tanggal' => $valSelisih->tanggal,
        //                             'no_akun' => $valSelisih->m_w_code . '.' . $valNotaSelisih->m_rekening_code,
        //                             'akun' => $valNotaSelisih->m_rekening_nama,
        //                             'particul' => 'selisih kasir' . $valSelisih->catatan . '- sesi ' . $valSelisih->sesi,
        //                             'debit' => number_format($valSelisih->nominal),
        //                             'kredit' => 0,
        //                             'urutan' => $urutan++,
        //                         );
        //                     }
        //                     foreach ($pendapatan_selisih_kasir as $valNotaSelisih) {
        //                         $data[$notaSelisih]['Selisih Pendapatan Plus'] = array(
        //                             'tanggal' => $valSelisih->tanggal,
        //                             'no_akun' => $valSelisih->m_w_code . '.' . $valNotaSelisih->m_rekening_code,
        //                             'akun' => $valNotaSelisih->m_rekening_nama,
        //                             'particul' => 'pendapatan selisih kasir ' . $valSelisih->catatan . '- sesi ' . $valSelisih->sesi,
        //                             'debit' => 0,
        //                             'kredit' => number_format($valSelisih->nominal),
        //                             'urutan' => $urutan++,
        //                         );
        //                     }
        //                 }
        //                 if ($valSelisih->nominal < 0) {
        //                     foreach ($biaya_selisih_kasir as $valNotaSelisih) {
        //                         $data[$notaSelisih]['Selisih Pendapatan Minus'] = array(
        //                             'tanggal' => $valSelisih->tanggal,
        //                             'no_akun' => $valSelisih->m_w_code . '.' . $valNotaSelisih->m_rekening_code,
        //                             'akun' => $valNotaSelisih->m_rekening_nama,
        //                             'particul' => 'biaya selisih kasir ' . $valSelisih->catatan . ' - sesi ' . $valSelisih->sesi,
        //                             'debit' => number_format(abs($valSelisih->nominal)),
        //                             'kredit' => 0,
        //                             'urutan' => $urutan++,
        //                         );
        //                     }
        //                     foreach ($selisih_kasir as $valNotaSelisih) {
        //                         $data[$notaSelisih]['Selisih Minus'] = array(
        //                             'tanggal' => $valSelisih->tanggal,
        //                             'no_akun' => $valSelisih->m_w_code . '.' . $valNotaSelisih->m_rekening_code,
        //                             'akun' => $valNotaSelisih->m_rekening_nama,
        //                             'particul' => 'selisih kasir ' . $valSelisih->catatan . ' - sesi ' . $valSelisih->sesi,
        //                             'debit' => 0,
        //                             'kredit' => number_format(abs($valSelisih->nominal)),
        //                             'urutan' => $urutan++,
        //                         );
        //                     }
        //                 }
        //             } //if selisih not 0
        //         } //if notacode
        //     } //selisih kasir
        // } //nota code

        // foreach ($data as $nota => $item) {
        //     foreach ($item as $type => $transaction) {
        //         if (isset($transaction['debit'])) {
        //             $totalDebit += floatval(str_replace(',', '', $transaction['debit']));
        //         }
        //         if (isset($transaction['kredit'])) {
        //             $totalKredit += floatval(str_replace(',', '', $transaction['kredit']));
        //         }
        //     }
        // }

        // $debit = number_format($totalDebit);
        // $kredit = number_format($totalKredit);

        // $data[$notaSelisih]['Total'] = array(
        //     'tanggal' => '',
        //     'no_akun' => '',
        //     'akun' => '',
        //     'particul' => '<strong> Total </strong>',
        //     'debit' => '<strong>' . $debit . '</strong>',
        //     'kredit' => '<strong>' . $kredit . '</strong>',
        //     'urutan' => $urutan++,
        // );

        $output = array();

        foreach ($data as $notaCode => $items) {
            usort($items, function ($a, $b) {
                return $a['urutan'] - $b['urutan'];
            });
            $sortedData[$notaCode] = $items;
        }

        $convert = [];
        foreach ($sortedData as $notaCode => $rows) {
            foreach ($rows as $row) {
                $convert[] = $row;
            }
        }

        $output = array(
            "data" => $convert,
        );

        return response()->json($output);
    }

}
