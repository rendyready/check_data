<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSyncRekapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::statement("TRUNCATE TABLE config_sync RESTART IDENTITY;");

        #Rekap
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_buka_laci',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'aktif',
            'config_sync_limit' => 100,
            'config_sync_field_status' => 'r_b_l_status_sync',
            'config_sync_field_validate1' => 'r_b_l_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_garansi',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'aktif',
            'config_sync_limit' => 100,
            'config_sync_field_status' => 'rekap_garansi_status_sync',
            'config_sync_field_validate1' => 'rekap_garansi_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_hapus_menu',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'aktif',
            'config_sync_limit' => 100,
            'config_sync_field_status' => 'r_h_m_status_sync',
            'config_sync_field_validate1' => 'r_h_m_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_hapus_transaksi',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'aktif',
            'config_sync_limit' => 100,
            'config_sync_field_status' => 'r_h_t_status_sync',
            'config_sync_field_validate1' => 'r_h_t_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_hapus_transaksi_detail',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'aktif',
            'config_sync_limit' => 100,
            'config_sync_field_status' => 'r_h_t_detail_status_sync',
            'config_sync_field_validate1' => 'r_h_t_detail_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_lost_bill',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'aktif',
            'config_sync_limit' => 100,
            'config_sync_field_status' => 'r_l_b_status_sync',
            'config_sync_field_validate1' => 'r_l_b_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_lost_bill_detail',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'aktif',
            'config_sync_limit' => 100,
            'config_sync_field_status' => 'r_l_b_detail_status_sync',
            'config_sync_field_validate1' => 'r_l_b_detail_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_member',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'aktif',
            'config_sync_limit' => 100,
            'config_sync_field_status' => 'rekap_member_status_sync',
            'config_sync_field_validate1' => 'rekap_member_phone'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_modal',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'aktif',
            'config_sync_limit' => 100,
            'config_sync_field_status' => 'rekap_modal_status_sync',
            'config_sync_field_validate1' => 'rekap_modal_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_modal_detail',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'aktif',
            'config_sync_limit' => 100,
            'config_sync_field_status' => 'rekap_modal_detail_status_sync',
            'config_sync_field_validate1' => 'rekap_modal_detail_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_mutasi_modal',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'aktif',
            'config_sync_limit' => 100,
            'config_sync_field_status' => 'r_m_m_status_sync',
            'config_sync_field_validate1' => 'r_m_m_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_uang_tips',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'aktif',
            'config_sync_limit' => 100,
            'config_sync_field_status' => 'r_u_t_status_sync',
            'config_sync_field_validate1' => 'r_u_t_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_transaksi',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'aktif',
            'config_sync_limit' => 100,
            'config_sync_field_status' => 'r_t_status_sync',
            'config_sync_field_validate1' => 'r_t_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_transaksi_detail',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'aktif',
            'config_sync_limit' => 100,
            'config_sync_field_status' => 'r_t_detail_status_sync',
            'config_sync_field_validate1' => 'r_t_detail_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_payment_transaksi',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'aktif',
            'config_sync_limit' => 100,
            'config_sync_field_status' => 'r_p_t_status_sync',
            'config_sync_field_validate1' => 'r_p_t_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_refund',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'aktif',
            'config_sync_limit' => 100,
            'config_sync_field_status' => 'r_r_status_sync',
            'config_sync_field_validate1' => 'r_r_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_refund_detail',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'aktif',
            'config_sync_limit' => 100,
            'config_sync_field_status' => 'r_r_detail_status_sync',
            'config_sync_field_validate1' => 'r_r_detail_id'
        ]);


    }
}
