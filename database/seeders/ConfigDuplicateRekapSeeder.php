<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigDuplicateRekapSeeder extends Seeder
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
            'config_sync_status' => 'on',
            'config_sync_for' => 'waroeng',
            'config_sync_tipe' => 'duplicaterekap',
            'config_sync_limit' => 100,
            'config_sync_field_pkey' => 'r_b_l_id',
            'config_sync_field_status' => 'r_b_l_client_target',
            'config_sync_field_validate1' => 'r_b_l_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_garansi',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'on',
            'config_sync_for' => 'waroeng',
            'config_sync_tipe' => 'duplicaterekap',
            'config_sync_limit' => 100,
            'config_sync_field_pkey' => 'rekap_garansi_id',
            'config_sync_field_status' => 'rekap_garansi_client_target',
            'config_sync_field_validate1' => 'rekap_garansi_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_hapus_menu',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'on',
            'config_sync_for' => 'waroeng',
            'config_sync_tipe' => 'duplicaterekap',
            'config_sync_limit' => 100,
            'config_sync_field_pkey' => 'r_h_m_id',
            'config_sync_field_status' => 'r_h_m_client_target',
            'config_sync_field_validate1' => 'r_h_m_rekap_modal_id',
            'config_sync_field_validate2' => 'r_h_m_nota_code',
            'config_sync_field_validate3' => 'r_h_m_m_produk_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_hapus_transaksi',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'on',
            'config_sync_for' => 'waroeng',
            'config_sync_tipe' => 'duplicaterekap',
            'config_sync_limit' => 100,
            'config_sync_field_pkey' => 'r_h_t_id',
            'config_sync_field_status' => 'r_h_t_client_target',
            'config_sync_field_validate1' => 'r_h_t_rekap_modal_id',
            'config_sync_field_validate2' => 'r_h_t_nota_code'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_hapus_transaksi_detail',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'on',
            'config_sync_for' => 'waroeng',
            'config_sync_tipe' => 'duplicaterekap',
            'config_sync_limit' => 100,
            'config_sync_field_pkey' => 'r_h_t_detail_id',
            'config_sync_field_status' => 'r_h_t_detail_client_target',
            'config_sync_field_validate1' => 'r_h_t_detail_r_h_t_id',
            'config_sync_field_validate2' => 'r_h_t_detail_m_produk_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_lost_bill',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'on',
            'config_sync_for' => 'waroeng',
            'config_sync_tipe' => 'duplicaterekap',
            'config_sync_limit' => 100,
            'config_sync_field_pkey' => 'r_l_b_id',
            'config_sync_field_status' => 'r_l_b_client_target',
            'config_sync_field_validate1' => 'r_l_b_rekap_modal_id',
            'config_sync_field_validate2' => 'r_l_b_nota_code'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_lost_bill_detail',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'on',
            'config_sync_for' => 'waroeng',
            'config_sync_tipe' => 'duplicaterekap',
            'config_sync_limit' => 100,
            'config_sync_field_pkey' => 'r_l_b_detail_id',
            'config_sync_field_status' => 'r_l_b_detail_client_target',
            'config_sync_field_validate1' => 'r_l_b_detail_r_l_b_id',
            'config_sync_field_validate2' => 'r_l_b_detail_m_produk_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_member',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'on',
            'config_sync_for' => 'waroeng',
            'config_sync_tipe' => 'duplicaterekap',
            'config_sync_limit' => 100,
            'config_sync_field_pkey' => 'rekap_member_phone',
            'config_sync_field_status' => 'rekap_member_client_target',
            'config_sync_field_validate1' => 'rekap_member_phone'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_modal',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'on',
            'config_sync_for' => 'waroeng',
            'config_sync_tipe' => 'duplicaterekap',
            'config_sync_limit' => 100,
            'config_sync_field_pkey' => 'rekap_modal_id',
            'config_sync_field_status' => 'rekap_modal_client_target',
            'config_sync_field_validate1' => 'rekap_modal_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_modal_detail',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'on',
            'config_sync_for' => 'waroeng',
            'config_sync_tipe' => 'duplicaterekap',
            'config_sync_limit' => 100,
            'config_sync_field_pkey' => 'rekap_modal_detail_id',
            'config_sync_field_status' => 'rekap_modal_detail_client_target',
            'config_sync_field_validate1' => 'rekap_modal_detail_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_mutasi_modal',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'on',
            'config_sync_for' => 'waroeng',
            'config_sync_tipe' => 'duplicaterekap',
            'config_sync_limit' => 100,
            'config_sync_field_pkey' => 'r_m_m_id',
            'config_sync_field_status' => 'r_m_m_client_target',
            'config_sync_field_validate1' => 'r_m_m_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_uang_tips',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'on',
            'config_sync_for' => 'waroeng',
            'config_sync_tipe' => 'duplicaterekap',
            'config_sync_limit' => 100,
            'config_sync_field_pkey' => 'r_u_t_id',
            'config_sync_field_status' => 'r_u_t_client_target',
            'config_sync_field_validate1' => 'r_u_t_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_transaksi',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'on',
            'config_sync_for' => 'waroeng',
            'config_sync_tipe' => 'duplicaterekap',
            'config_sync_limit' => 100,
            'config_sync_field_pkey' => 'r_t_id',
            'config_sync_field_status' => 'r_t_client_target',
            'config_sync_field_validate1' => 'r_t_rekap_modal_id',
            'config_sync_field_validate2' => 'r_t_nota_code',
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_transaksi_detail',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'on',
            'config_sync_for' => 'waroeng',
            'config_sync_tipe' => 'duplicaterekap',
            'config_sync_limit' => 100,
            'config_sync_field_pkey' => 'r_t_detail_id',
            'config_sync_field_status' => 'r_t_detail_client_target',
            'config_sync_field_validate1' => 'r_t_detail_r_t_id',
            'config_sync_field_validate2' => 'r_t_detail_m_produk_id',
            'config_sync_field_validate3' => 'r_t_detail_status'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_payment_transaksi',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'on',
            'config_sync_for' => 'waroeng',
            'config_sync_tipe' => 'duplicaterekap',
            'config_sync_limit' => 100,
            'config_sync_field_pkey' => 'r_p_t_id',
            'config_sync_field_status' => 'r_p_t_client_target',
            'config_sync_field_validate1' => 'r_p_t_r_t_id',
            'config_sync_field_validate2' => 'r_p_t_m_payment_method_id',
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_refund',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'on',
            'config_sync_for' => 'waroeng',
            'config_sync_tipe' => 'duplicaterekap',
            'config_sync_limit' => 100,
            'config_sync_field_pkey' => 'r_r_id',
            'config_sync_field_status' => 'r_r_client_target',
            'config_sync_field_validate1' => 'r_r_rekap_modal_id',
            'config_sync_field_validate2' => 'r_r_nota_code',
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'rekap_refund_detail',
            'config_sync_table_tipe' => 'transaksi',
            'config_sync_status' => 'on',
            'config_sync_for' => 'waroeng',
            'config_sync_tipe' => 'duplicaterekap',
            'config_sync_limit' => 100,
            'config_sync_field_pkey' => 'r_r_detail_id',
            'config_sync_field_status' => 'r_r_detail_client_target',
            'config_sync_field_validate1' => 'r_r_detail_r_r_id',
            'config_sync_field_validate2' => 'r_r_detail_m_produk_id'
        ]);

    }
}
