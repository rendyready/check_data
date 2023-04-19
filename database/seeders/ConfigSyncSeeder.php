<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSyncSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("TRUNCATE TABLE config_sync RESTART IDENTITY;");
        $table[1] = 'users';
        $table[2] = 'm_area';
        $table[3] = 'm_pajak';
        $table[4] = 'm_sc';
        $table[5] = 'm_w_jenis';
        $table[6] = 'm_w';
        $table[7] = 'm_footer';
        $table[8] = 'm_jenis_nota';
        $table[9] = 'm_menu_harga';
        $table[10] = 'm_jenis_produk';
        $table[11] = 'm_klasifikasi_produk';
        $table[12] = 'm_plot_produksi';
        $table[13] = 'm_satuan';
        $table[14] = 'm_produk';
        $table[15] = 'm_sub_jenis_produk';
        $table[16] = 'config_sub_jenis_produk';
        $table[17] = 'm_kasir_akses';
        $table[18] = 'm_meja_jenis';
        $table[19] = 'm_meja';
        $table[20] = 'm_modal_tipe';
        $table[21] = 'm_payment_method';
        $table[22] = 'app_setting';
        $table[23] = 'm_karyawan';
        $table[24] = 'm_jabatan';
        $table[25] = 'history_pendidikan';
        $table[26] = 'history_jabatan';

        foreach ($table as $key => $valTable) {
            DB::table('config_sync')->insert([
                'config_sync_table_name' => $valTable,
                'config_sync_table_tipe' => 'master',
                'config_sync_status' => 'aktif',
                'config_sync_limit' => 100,
                'config_sync_field_status' => $valTable."_status_sync",
                'config_sync_field_validate1' => $valTable.'_id'
            ]);
        }

        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'roles',
            'config_sync_table_tipe' => 'master',
            'config_sync_status' => 'aktif',
            'config_sync_limit' => 100,
            'config_sync_field_status' => 'roles_status_sync',
            'config_sync_field_validate1' => 'id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'role_has_permissions',
            'config_sync_table_tipe' => 'master',
            'config_sync_status' => 'aktif',
            'config_sync_limit' => 100,
            'config_sync_field_status' => 'r_h_p_status_sync',
            'config_sync_field_validate1' => 'permission_id',
            'config_sync_field_validate2' => 'role_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'model_has_permissions',
            'config_sync_table_tipe' => 'master',
            'config_sync_status' => 'aktif',
            'config_sync_limit' => 100,
            'config_sync_field_status' => 'm_h_p_status_sync',
            'config_sync_field_validate1' => 'model_id',
            'config_sync_field_validate2' => 'permission_id'
        ]);
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'model_has_roles',
            'config_sync_table_tipe' => 'master',
            'config_sync_status' => 'aktif',
            'config_sync_limit' => 100,
            'config_sync_field_status' => 'm_h_r_status_sync',
            'config_sync_field_validate1' => 'model_id'
        ]);

        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'm_transaksi_tipe',
            'config_sync_table_tipe' => 'master',
            'config_sync_status' => 'aktif',
            'config_sync_limit' => 100,
            'config_sync_field_status' => 'm_t_t_status_sync',
            'config_sync_field_validate1' => 'm_t_t_id'
        ]);

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

        // DB::table('config_sync')->insert([
        //     'config_sync_table_name' => 'app_setting',
        //     'config_sync_table_tipe' => 'master',
        //     'config_sync_status' => 'aktif',
        //     'config_sync_limit' => 100,
        //     'config_sync_field_status' => NULL,
        //     'config_sync_field_validate1' => 'app_setting_id'
        // ]);

        // DB::table('config_sync')->insert([
        //     'config_sync_table_name' => 'm_area',
        //     'config_sync_table_tipe' => 'master',
        //     'config_sync_status' => 'aktif',
        //     'config_sync_limit' => 100,
        //     'config_sync_field_status' => NULL,
        //     'config_sync_field_validate1' => 'm_area_id'
        // ]);

        // DB::table('config_sync')->insert([
        //     'config_sync_table_name' => 'm_w_jenis',
        //     'config_sync_table_tipe' => 'master',
        //     'config_sync_status' => 'aktif',
        //     'config_sync_limit' => 100,
        //     'config_sync_field_status' => NULL,
        //     'config_sync_field_validate1' => 'm_w_jenis_id'
        // ]);

        // DB::table('config_sync')->insert([
        //     'config_sync_table_name' => 'm_pajak',
        //     'config_sync_table_tipe' => 'master',
        //     'config_sync_status' => 'aktif',
        //     'config_sync_limit' => 100,
        //     'config_sync_field_status' => NULL,
        //     'config_sync_field_validate1' => 'm_pajak_id'
        // ]);

        // DB::table('config_sync')->insert([
        //     'config_sync_table_name' => 'm_sc',
        //     'config_sync_table_tipe' => 'master',
        //     'config_sync_status' => 'aktif',
        //     'config_sync_limit' => 100,
        //     'config_sync_field_status' => NULL,
        //     'config_sync_field_validate1' => 'm_sc_id'
        // ]);

        // DB::table('config_sync')->insert([
        //     'config_sync_table_name' => 'm_w',
        //     'config_sync_table_tipe' => 'master',
        //     'config_sync_status' => 'aktif',
        //     'config_sync_limit' => 100,
        //     'config_sync_field_status' => NULL,
        //     'config_sync_field_validate1' => 'm_w_id'
        // ]);

        // DB::table('config_sync')->insert([
        //     'config_sync_table_name' => 'm_footer',
        //     'config_sync_table_tipe' => 'master',
        //     'config_sync_status' => 'aktif',
        //     'config_sync_limit' => 100,
        //     'config_sync_field_status' => NULL,
        //     'config_sync_field_validate1' => 'm_footer_id'
        // ]);
        // DB::table('config_sync')->insert([
        //     'config_sync_table_name' => 'm_meja_jenis',
        //     'config_sync_table_tipe' => 'master',
        //     'config_sync_status' => 'aktif',
        //     'config_sync_limit' => 100,
        //     'config_sync_field_status' => NULL,
        //     'config_sync_field_validate1' => 'm_meja_jenis_id'
        // ]);
        // DB::table('config_sync')->insert([
        //     'config_sync_table_name' => 'm_meja',
        //     'config_sync_table_tipe' => 'master',
        //     'config_sync_status' => 'aktif',
        //     'config_sync_limit' => 100,
        //     'config_sync_field_status' => NULL,
        //     'config_sync_field_validate1' => 'm_meja_id'
        // ]);
        // DB::table('config_sync')->insert([
        //     'config_sync_table_name' => 'm_jenis_produk',
        //     'config_sync_table_tipe' => 'master',
        //     'config_sync_status' => 'aktif',
        //     'config_sync_limit' => 100,
        //     'config_sync_field_status' => NULL,
        //     'config_sync_field_validate1' => 'm_jenis_produk_id'
        // ]);
        // DB::table('config_sync')->insert([
        //     'config_sync_table_name' => 'm_klasifikasi_produk',
        //     'config_sync_table_tipe' => 'master',
        //     'config_sync_status' => 'aktif',
        //     'config_sync_limit' => 100,
        //     'config_sync_field_status' => NULL,
        //     'config_sync_field_validate1' => 'm_klasifikasi_produk_id'
        // ]);
        // DB::table('config_sync')->insert([
        //     'config_sync_table_name' => 'm_plot_produksi',
        //     'config_sync_table_tipe' => 'master',
        //     'config_sync_status' => 'aktif',
        //     'config_sync_limit' => 100,
        //     'config_sync_field_status' => NULL,
        //     'config_sync_field_validate1' => 'm_plot_produksi_id'
        // ]);
        // DB::table('config_sync')->insert([
        //     'config_sync_table_name' => 'm_satuan',
        //     'config_sync_table_tipe' => 'master',
        //     'config_sync_status' => 'aktif',
        //     'config_sync_limit' => 100,
        //     'config_sync_field_status' => NULL,
        //     'config_sync_field_validate1' => 'm_satuan_id'
        // ]);
        // DB::table('config_sync')->insert([
        //     'config_sync_table_name' => 'm_produk',
        //     'config_sync_table_tipe' => 'master',
        //     'config_sync_status' => 'aktif',
        //     'config_sync_limit' => 100,
        //     'config_sync_field_status' => NULL,
        //     'config_sync_field_validate1' => 'm_produk_id'
        // ]);
        // DB::table('config_sync')->insert([
        //     'config_sync_table_name' => 'm_sub_jenis_produk',
        //     'config_sync_table_tipe' => 'master',
        //     'config_sync_status' => 'aktif',
        //     'config_sync_limit' => 100,
        //     'config_sync_field_status' => NULL,
        //     'config_sync_field_validate1' => 'm_sub_jenis_produk_id'
        // ]);
        // DB::table('config_sync')->insert([
        //     'config_sync_table_name' => 'config_sub_jenis_produk',
        //     'config_sync_table_tipe' => 'master',
        //     'config_sync_status' => 'aktif',
        //     'config_sync_limit' => 100,
        //     'config_sync_field_status' => NULL,
        //     'config_sync_field_validate1' => 'config_sub_jenis_produk_id'
        // ]);
        // DB::table('config_sync')->insert([
        //     'config_sync_table_name' => 'm_jenis_nota',
        //     'config_sync_table_tipe' => 'master',
        //     'config_sync_status' => 'aktif',
        //     'config_sync_limit' => 100,
        //     'config_sync_field_status' => NULL,
        //     'config_sync_field_validate1' => 'm_jenis_nota_id'
        // ]);
        // DB::table('config_sync')->insert([
        //     'config_sync_table_name' => 'm_menu_harga',
        //     'config_sync_table_tipe' => 'master',
        //     'config_sync_status' => 'aktif',
        //     'config_sync_limit' => 100,
        //     'config_sync_field_status' => NULL,
        //     'config_sync_field_validate1' => 'm_menu_harga_id'
        // ]);
        // DB::table('config_sync')->insert([
        //     'config_sync_table_name' => 'm_kasir_akses',
        //     'config_sync_table_tipe' => 'master',
        //     'config_sync_status' => 'aktif',
        //     'config_sync_limit' => 100,
        //     'config_sync_field_status' => NULL,
        //     'config_sync_field_validate1' => 'm_kasir_akses_id'
        // ]);
        // DB::table('config_sync')->insert([
        //     'config_sync_table_name' => 'm_modal_tipe',
        //     'config_sync_table_tipe' => 'master',
        //     'config_sync_status' => 'aktif',
        //     'config_sync_limit' => 100,
        //     'config_sync_field_status' => NULL,
        //     'config_sync_field_validate1' => 'm_modal_tipe_id'
        // ]);
        // DB::table('config_sync')->insert([
        //     'config_sync_table_name' => 'm_payment_method',
        //     'config_sync_table_tipe' => 'master',
        //     'config_sync_status' => 'aktif',
        //     'config_sync_limit' => 100,
        //     'config_sync_field_status' => NULL,
        //     'config_sync_field_validate1' => 'm_payment_method_id'
        // ]);
        // DB::table('config_sync')->insert([
        //     'config_sync_table_name' => 'm_transaksi_tipe',
        //     'config_sync_table_tipe' => 'master',
        //     'config_sync_status' => 'aktif',
        //     'config_sync_limit' => 100,
        //     'config_sync_field_status' => NULL,
        //     'config_sync_field_validate1' => 'm_t_t_id'
        // ]);
        // DB::table('config_sync')->insert([
        //     'config_sync_table_name' => 'users',
        //     'config_sync_table_tipe' => 'master',
        //     'config_sync_status' => 'aktif',
        //     'config_sync_limit' => 100,
        //     'config_sync_field_status' => NULL,
        //     'config_sync_field_validate1' => 'users_id'
        // ]);

    }
}
