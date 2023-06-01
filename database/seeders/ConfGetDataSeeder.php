<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfGetDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("TRUNCATE TABLE config_get_data RESTART IDENTITY;");
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
        $table[27] = 'm_group_produk';
        // $table[28] = 'm_resep';
        // $table[29] = 'm_resep_detail';
        // $table[30] = 'm_supplier';
        $table[31] = 'm_level_jabatan';
        // $table[32] = 'm_stok';
        // $table[33] = 'm_stok_detail';
        // $table[34] = 'm_gudang';
        // $table[35] = 'm_gudang_nama';

        foreach ($table as $key => $valTable) {
            $seq = ($valTable == 'app_setting') ? 'off':'on';
            // $trun = ($valTable == 'app_setting') ? 'on':'off';
            $trun = 'off';
            $limit = ($valTable == 'm_menu_harga') ? 2000 : 100;

            DB::table('config_get_data')->insert([
                'config_get_data_table_name' => $valTable,
                'config_get_data_table_tipe' => 'master',
                'config_get_data_status' => 'on',
                'config_get_data_limit' => $limit,
                'config_get_data_truncate' => $trun,
                'config_get_data_sequence' => $seq,
                'config_get_data_field_status' => $valTable."_status_sync",
                'config_get_data_field_validate1' => $valTable.'_id'
            ]);
        }

        DB::table('config_get_data')->insert([
            'config_get_data_table_name' => 'roles',
            'config_get_data_table_tipe' => 'master',
            'config_get_data_status' => 'on',
            'config_get_data_limit' => 0,
            'config_get_data_sequence' => 'on',
            'config_get_data_field_status' => 'roles_status_sync',
            'config_get_data_field_validate1' => 'id'
        ]);
        DB::table('config_get_data')->insert([
            'config_get_data_table_name' => 'permissions',
            'config_get_data_table_tipe' => 'master',
            'config_get_data_status' => 'on',
            'config_get_data_limit' => 0,
            'config_get_data_sequence' => 'on',
            'config_get_data_field_status' => 'permissions_status_sync',
            'config_get_data_field_validate1' => 'id'
        ]);
        DB::table('config_get_data')->insert([
            'config_get_data_table_name' => 'role_has_permissions',
            'config_get_data_table_tipe' => 'master',
            'config_get_data_status' => 'on',
            'config_get_data_limit' => 1000,
            'config_get_data_sequence' => 'off',
            'config_get_data_field_status' => 'r_h_p_status_sync',
            'config_get_data_field_validate1' => 'r_h_p_id',
            // 'config_get_data_field_validate1' => 'permission_id',
            // 'config_get_data_field_validate2' => 'role_id'
        ]);
        DB::table('config_get_data')->insert([
            'config_get_data_table_name' => 'model_has_permissions',
            'config_get_data_table_tipe' => 'master',
            'config_get_data_status' => 'on',
            'config_get_data_limit' => 1000,
            'config_get_data_sequence' => 'off',
            'config_get_data_field_status' => 'm_h_p_status_sync',
            'config_get_data_field_validate1' => 'm_h_p_id',
            // 'config_get_data_field_validate1' => 'model_id',
            // 'config_get_data_field_validate2' => 'permission_id'
        ]);
        DB::table('config_get_data')->insert([
            'config_get_data_table_name' => 'model_has_roles',
            'config_get_data_table_tipe' => 'master',
            'config_get_data_status' => 'on',
            'config_get_data_limit' => 1000,
            'config_get_data_sequence' => 'off',
            'config_get_data_field_status' => 'm_h_r_status_sync',
            'config_get_data_field_validate1' => 'm_h_r_id'
            // 'config_get_data_field_validate1' => 'model_id'
        ]);

        DB::table('config_get_data')->insert([
            'config_get_data_table_name' => 'm_transaksi_tipe',
            'config_get_data_table_tipe' => 'master',
            'config_get_data_status' => 'on',
            'config_get_data_limit' => 100,
            'config_get_data_sequence' => 'on',
            'config_get_data_field_status' => 'm_t_t_status_sync',
            'config_get_data_field_validate1' => 'm_t_t_id'
        ]);


    }
}
