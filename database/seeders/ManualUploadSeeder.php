<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ManualUploadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rekap_buka_laci')
            ->where('r_b_l_tanggal', '>', '2023-08-26')
            ->update(['r_b_l_client_target' => ':1::2::3::4::5::6::27::36::52::70::83::101::110::116::119::120:']);

        DB::table('rekap_garansi')
            ->join('rekap_transaksi', 'r_t_id', 'rekap_garansi_r_t_id')
            ->where('r_t_tanggal', '>', '2023-08-26')
            ->update(['rekap_garansi_client_target' => ':1::2::3::4::5::6::27::36::52::70::83::101::110::116::119::120:']);

        DB::table('rekap_hapus_menu')
            ->where('r_h_m_tanggal', '>', '2023-08-26')
            ->update(['r_h_m_client_target' => ':1::2::3::4::5::6::27::36::52::70::83::101::110::116::119::120:']);

        DB::table('rekap_hapus_transaksi')
            ->where('r_h_t_tanggal', '>', '2023-08-26')
            ->update(['r_h_m_client_target' => ':1::2::3::4::5::6::27::36::52::70::83::101::110::116::119::120:']);

        DB::table('rekap_hapus_transaksi_detail')
            ->join('rekap_hapus_transaksi', 'r_h_t_id', 'r_h_t_detail_r_h_t_id')
            ->where('r_h_t_tanggal', '>', '2023-08-26')
            ->update(['r_h_t_detail_client_target' => ':1::2::3::4::5::6::27::36::52::70::83::101::110::116::119::120:']);

        DB::table('rekap_lost_bill')
            ->where('r_l_b_tanggal', '>', '2023-08-26')
            ->update(['r_l_b_client_target' => ':1::2::3::4::5::6::27::36::52::70::83::101::110::116::119::120:']);

        DB::table('rekap_lost_bill_detail')
            ->join('rekap_lost_bill', 'r_l_b_id', 'r_l_b_detail_r_l_b_id')
            ->where('r_l_b_tanggal', '>', '2023-08-26')
            ->update(['r_l_b_detail_client_target' => ':1::2::3::4::5::6::27::36::52::70::83::101::110::116::119::120:']);

        DB::table('rekap_modal')
            ->where(DB::raw('DATE(rekap_modal_tanggal)'), '>', '2023-08-26')
            ->update(['rekap_modal_client_target' => ':1::2::3::4::5::6::27::36::52::70::83::101::110::116::119::120:']);

        DB::table('rekap_modal_detail')
            ->join('rekap_modal', 'rekap_modal_id', 'rekap_modal_detail_rekap_modal_id')
            ->where(DB::raw('DATE(rekap_modal_tanggal)'), '>', '2023-08-26')
            ->update(['rekap_modal_detail_client_target' => ':1::2::3::4::5::6::27::36::52::70::83::101::110::116::119::120:']);

        DB::table('rekap_mutasi_modal')
            ->where('r_m_m_tanggal', '>', '2023-08-26')
            ->update(['r_m_m_client_target' => ':1::2::3::4::5::6::27::36::52::70::83::101::110::116::119::120:']);

        DB::table('rekap_payment_transaksi')
            ->join('rekap_transaksi', 'r_t_id', 'r_p_t_r_t_id')
            ->where('r_t_tanggal', '>', '2023-08-26')
            ->update(['r_p_t_client_target' => ':1::2::3::4::5::6::27::36::52::70::83::101::110::116::119::120:']);

        DB::table('rekap_refund')
            ->where('r_r_tanggal', '>', '2023-08-26')
            ->update(['r_r_client_target' => ':1::2::3::4::5::6::27::36::52::70::83::101::110::116::119::120:']);

        DB::table('rekap_refund_detail')
            ->join('rekap_refund', 'r_r_id', 'r_r_detail_r_r_id')
            ->where('r_r_tanggal', '>', '2023-08-26')
            ->update(['r_r_detail_client_target' => ':1::2::3::4::5::6::27::36::52::70::83::101::110::116::119::120:']);

        DB::table('rekap_transaksi')
            ->where('r_t_tanggal', '>', '2023-08-26')
            ->update(['r_t_client_target' => ':1::2::3::4::5::6::27::36::52::70::83::101::110::116::119::120:']);

        DB::table('rekap_transaksi_detail')
            ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
            ->where('r_t_tanggal', '>', '2023-08-26')
            ->update(['r_t_detail_client_target' => ':1::2::3::4::5::6::27::36::52::70::83::101::110::116::119::120:']);
    }
}