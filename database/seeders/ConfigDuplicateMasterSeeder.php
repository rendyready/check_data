<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigDuplicateMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::statement("TRUNCATE TABLE config_sync RESTART IDENTITY;");
        $data = [
            [
                "tableName" => "users",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "users_id",
                "field_status" => "users_client_target",
                "field_validate1" => "users_id",
                "field_validate2" => "email",
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "m_area",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "m_area_id",
                "field_status" => "m_area_client_target",
                "field_validate1" => "m_area_id",
                "field_validate2" => NULL,
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "m_pajak",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "m_pajak_id",
                "field_status" => "m_pajak_client_target",
                "field_validate1" => "m_pajak_id",
                "field_validate2" => NULL,
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "m_sc",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "m_sc_id",
                "field_status" => "m_sc_client_target",
                "field_validate1" => "m_sc_id",
                "field_validate2" => NULL,
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "m_w_jenis",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "m_w_jenis_id",
                "field_status" => "m_w_jenis_client_target",
                "field_validate1" => "m_w_jenis_id",
                "field_validate2" => NULL,
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "m_w",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "m_w_id",
                "field_status" => "m_w_client_target",
                "field_validate1" => "m_w_id",
                "field_validate2" => NULL,
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "m_footer",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "m_footer_id",
                "field_status" => "m_footer_client_target",
                "field_validate1" => "m_footer_id",
                "field_validate2" => NULL,
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "m_jenis_nota",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "m_jenis_nota_id",
                "field_status" => "m_jenis_nota_client_target",
                "field_validate1" => "m_jenis_nota_m_w_id",
                "field_validate2" => "m_jenis_nota_m_t_t_id",
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "m_menu_harga",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "m_menu_harga_id",
                "field_status" => "m_menu_harga_client_target",
                "field_validate1" => "m_menu_harga_m_jenis_nota_id",
                "field_validate2" => "m_menu_harga_m_produk_id",
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "m_jenis_produk",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "m_jenis_produk_id",
                "field_status" => "m_jenis_produk_client_target",
                "field_validate1" => "m_jenis_produk_id",
                "field_validate1" => "m_jenis_produk_id",
                "field_validate2" => NULL,
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "m_klasifikasi_produk",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "m_klasifikasi_produk_id",
                "field_status" => "m_klasifikasi_produk_client_target",
                "field_validate1" => "m_klasifikasi_produk_id",
                "field_validate1" => "m_klasifikasi_produk_id",
                "field_validate2" => NULL,
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "m_plot_produksi",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "m_plot_produksi_id",
                "field_status" => "m_plot_produksi_client_target",
                "field_validate1" => "m_plot_produksi_id",
                "field_validate1" => "m_plot_produksi_id",
                "field_validate2" => NULL,
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "m_satuan",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "m_satuan_id",
                "field_status" => "m_satuan_client_target",
                "field_validate1" => "m_satuan_id",
                "field_validate1" => "m_satuan_id",
                "field_validate2" => NULL,
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "m_produk",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "m_produk_id",
                "field_status" => "m_produk_client_target",
                "field_validate1" => "m_produk_nama",
                "field_validate2" => "m_produk_code",
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "m_sub_jenis_produk",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "m_sub_jenis_produk_id",
                "field_status" => "m_sub_jenis_produk_client_target",
                "field_validate1" => "m_sub_jenis_produk_nama",
                "field_validate2" => "m_sub_jenis_produk_m_jenis_produk_id",
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "config_sub_jenis_produk",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "config_sub_jenis_produk_id",
                "field_status" => "config_sub_jenis_produk_client_target",
                "field_validate1" => "config_sub_jenis_produk_m_produk_id",
                "field_validate2" => "config_sub_jenis_produk_m_sub_jenis_produk_id",
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "m_kasir_akses",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "m_kasir_akses_id",
                "field_status" => "m_kasir_akses_client_target",
                "field_validate1" => "m_kasir_akses_m_w_id",
                "field_validate2" => "m_kasir_akses_fitur",
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "m_meja_jenis",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "m_meja_jenis_id",
                "field_status" => "m_meja_jenis_client_target",
                "field_validate1" => "m_meja_jenis_nama",
                "field_validate2" => NULL,
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "m_meja",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "m_meja_id",
                "field_status" => "m_meja_client_target",
                "field_validate1" => "m_meja_m_w_id",
                "field_validate2" => "m_meja_nama",
                "field_validate3" => "m_meja_type",
                "field_validate4" => NULL
            ],
            [
                "tableName" => "m_modal_tipe",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "m_modal_tipe_id",
                "field_status" => "m_modal_tipe_client_target",
                "field_validate1" => "m_modal_tipe_id",
                "field_validate2" => NULL,
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "m_payment_method",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "m_payment_method_id",
                "field_status" => "m_payment_method_client_target",
                "field_validate1" => "m_payment_method_id",
                "field_validate2" => NULL,
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "app_setting",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "on",
                "field_pkey" => "app_setting_id",
                "field_status" => "app_setting_client_target",
                "field_validate1" => "app_setting_id",
                "field_validate2" => NULL,
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "m_karyawan",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "m_karyawan_id",
                "field_status" => "m_karyawan_client_target",
                "field_validate1" => "m_karyawan_nama",
                "field_validate2" => "m_karyawan_nik",
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "history_pendidikan",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "history_pendidikan_id",
                "field_status" => "history_pendidikan_client_target",
                "field_validate1" => "history_pendidikan_id",
                "field_validate2" => NULL,
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "history_jabatan",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "history_jabatan_id",
                "field_status" => "history_jabatan_client_target",
                "field_validate1" => "history_jabatan_id",
                "field_validate2" => NULL,
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "m_group_produk",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "m_group_produk_id",
                "field_status" => "m_group_produk_client_target",
                "field_validate1" => "m_group_produk_id",
                "field_validate2" => NULL,
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "m_level_jabatan",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "m_level_jabatan_id",
                "field_status" => "m_level_jabatan_client_target",
                "field_validate1" => "m_level_jabatan_id",
                "field_validate2" => NULL,
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "roles",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "on",
                "field_pkey" => "id",
                "field_status" => "roles_client_target",
                "field_validate1" => "name",
                "field_validate2" => NULL,
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            [
                "tableName" => "permissions",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "on",
                "field_pkey" => "id",
                "field_status" => "permissions_client_target",
                "field_validate1" => "name",
                "field_validate2" => NULL,
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
            // [
            //     "tableName" => "role_has_permissions",
            //     'config_sync_tipe' => 'duplicatemaster',
            //     "limit" => 100,
            //     "sequence" => "off",
            //     "field_status" => "r_h_p_client_target",
            //     "field_validate1" => "r_h_p_id",
            //     "field_validate2" => NULL,
            //     "field_validate3" => NULL,
            //     "field_validate4" => NULL
            // ],
            // [
            //     "tableName" => "model_has_permissions",
            //     'config_sync_tipe' => 'duplicatemaster',
            //     "limit" => 100,
            //     "sequence" => "off",
            //     "field_status" => "m_h_p_client_target",
            //     "field_validate1" => "m_h_p_id",
            //     "field_validate2" => NULL,
            //     "field_validate3" => NULL,
            //     "field_validate4" => NULL
            // ],
            // [
            //     "tableName" => "model_has_roles",
            //     'config_sync_tipe' => 'duplicatemaster',
            //     "limit" => 100,
            //     "sequence" => "off",
            //     "field_status" => "m_h_r_client_target",
            //     "field_validate1" => "m_h_r_id",
            //     "field_validate2" => NULL,
            //     "field_validate3" => NULL,
            //     "field_validate4" => NULL
            // ],
            [
                "tableName" => "m_transaksi_tipe",
                'config_sync_tipe' => 'duplicatemaster',
                "limit" => 100,
                "sequence" => "off",
                "field_pkey" => "m_t_t_id",
                "field_status" => "m_t_t_client_target",
                "field_validate1" => "m_t_t_name",
                "field_validate2" => NULL,
                "field_validate3" => NULL,
                "field_validate4" => NULL
            ],
        ];


        foreach ($data as $key => $val) {
            DB::table('config_sync')->insert([
                'config_sync_table_name' => $val['tableName'],
                'config_sync_table_tipe' => 'master',
                'config_sync_status' => 'on',
                'config_sync_for' => 'waroeng',
                'config_sync_tipe' => $val['config_sync_tipe'],
                'config_sync_limit' => $val['limit'],
                'config_sync_truncate' => 'off',
                'config_sync_sequence' => $val['sequence'],
                'config_sync_field_pkey' => $val['field_pkey'],
                'config_sync_field_status' => NULL,
                'config_sync_field_validate1' => $val['field_validate1'],
                'config_sync_field_validate2' => $val['field_validate2'],
                'config_sync_field_validate3' => $val['field_validate3'],
                'config_sync_field_validate4' => $val['field_validate4']
            ]);
        }

        foreach ($data as $key => $val) {
            DB::table('config_sync')->insert([
                'config_sync_table_name' => $val['tableName'],
                'config_sync_table_tipe' => 'master',
                'config_sync_status' => 'on',
                'config_sync_for' => 'area',
                'config_sync_tipe' => $val['config_sync_tipe'],
                'config_sync_limit' => $val['limit'],
                'config_sync_truncate' => 'off',
                'config_sync_sequence' => $val['sequence'],
                'config_sync_field_pkey' => $val['field_pkey'],
                'config_sync_field_status' => NULL,
                'config_sync_field_validate1' => $val['field_validate1'],
                'config_sync_field_validate2' => $val['field_validate2'],
                'config_sync_field_validate3' => $val['field_validate3'],
                'config_sync_field_validate4' => $val['field_validate4']
            ]);
        }

    }
}
