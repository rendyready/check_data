<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Helpers\JangkrikHelper;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Schema\Blueprint;


class MyController extends Controller
{
    function sendMaster($target){
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
        $table[28] = 'm_level_jabatan';
        // $table[28] = 'm_resep';
        // $table[29] = 'm_resep_detail';
        // $table[30] = 'm_supplier';
        // $table[32] = 'm_stok';
        // $table[33] = 'm_stok_detail';
        // $table[34] = 'm_gudang';
        // $table[35] = 'm_gudang_nama';
        foreach ($table as $key => $valTable) {

            if ($target != "all") {
                $expTarget = explode("-",$target);
                $newTarget = '';
                foreach ($expTarget as $key => $valTarget) {
                    $newTarget .= ':'.$valTarget.':';
                }
                $finalTarget = DB::raw($valTable."_client_target||'{$newTarget}'");
            } else {
                $finalTarget = DB::raw('DEFAULT');
            }

            $fieldName = $valTable."_client_target";
            DB::table($valTable)
            ->update([
                $fieldName => $finalTarget
            ]);
        }

        DB::table('roles')
            ->update([
                'roles_client_target' => ($target != "all") ? DB::raw("roles_client_target||'{$newTarget}'") : DB::raw('DEFAULT')
            ]);

        DB::table('permissions')
            ->update([
                'permissions_client_target' => ($target != "all") ? DB::raw("permissions_client_target||'{$newTarget}'") : DB::raw('DEFAULT')
            ]);

        DB::table('role_has_permissions')
            ->update([
                'r_h_p_client_target' => ($target != "all") ? DB::raw("r_h_p_client_target||'{$newTarget}'") : DB::raw('DEFAULT')
            ]);

        DB::table('model_has_permissions')
            ->update([
                'm_h_p_client_target' => ($target != "all") ? DB::raw("m_h_p_client_target||'{$newTarget}'") : DB::raw('DEFAULT')
            ]);

        DB::table('model_has_roles')
            ->update([
                'm_h_r_client_target' => ($target != "all") ? DB::raw("m_h_r_client_target||'{$newTarget}'") : DB::raw('DEFAULT')
            ]);

        DB::table('m_transaksi_tipe')
            ->update([
                'm_t_t_client_target' => ($target != "all") ? DB::raw("m_t_t_client_target||'{$newTarget}'") : DB::raw('DEFAULT')
            ]);

        return "DONE";
    }

    function uploadImage(){
        #Send Image to public server
        $img = url("/struct/lele.jpeg");
        $folder = 'produk';

        $image = fopen($img, 'r');
        $upload = Http::withHeaders([
            'accept' => 'application/json',
            'X-Authorization' => 'aD1UnchysFUfRHMqi61TWiZT7gjAFNAmnDrjkUFvVgrXIJplWasWvylDuZismZnO'
        ])
        ->attach('image',$image)
        ->post('https://struk.pedasabis.com/api/upload-image',[
            "folder" => $folder
        ]);
        return response($upload,200);
    }

    function deleteImage(){
        $urlImage = "https://struk.pedasabis.com/storage/produk/tes.jpg";
        #delete image from cloud storage
        $delete = Http::withHeaders([
            'accept' => 'application/json',
            'X-Authorization' => 'aD1UnchysFUfRHMqi61TWiZT7gjAFNAmnDrjkUFvVgrXIJplWasWvylDuZismZnO'
        ])
        ->post('https://struk.pedasabis.com/api/delete-image',[
            "url" => $urlImage
        ]);
        return response($delete,200);
   }


    function upgradeDb($target){
        #Create Connection To Cronjob DB
        Config::set("database.connections.cronjob", [
            'driver' => 'pgsql',
            // 'host' => env('DB_HOST', '127.0.0.1'),
            // 'port' => env('DB_PORT', '5432'),
            // 'database' => 'cronjob',
            // 'username' => 'ihsanmac',
            // 'password' => 'jangkrik404',
            'host' => '10.20.30.21',
            'port' => '5884',
            'database' => 'admin_cronjob',
            'username' => 'admin_cronjob',
            'password' => 'Cron@55wss',
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ]);
        $DbCron = DB::connection('cronjob');

        #Get List Server
        $server = $DbCron->table('db_con')
        ->where('db_con_sync_status','on')
        ->whereNotIn('db_con_id',['1'])
        ->orderBy('db_con_id','asc');
        if ($target != "all") {
            $server->where('db_con_m_w_id',$target);
        }

        $sipedasPusat = $DbCron->table('db_con')
        ->where('db_con_id','1')->first();
        Config::set("database.connections.pusat", [
            // App::make('config')->set('database.connections.client', [
                'driver' => $sipedasPusat->db_con_driver,
                'host' => '10.20.30.21',
                'port' => '5884',
                'database' => $sipedasPusat->db_con_dbname,
                'username' => $sipedasPusat->db_con_username,
                'password' => JangkrikHelper::customDecrypt($sipedasPusat->db_con_password),
                'charset' => 'utf8',
                'prefix' => '',
                'prefix_indexes' => true,
                'search_path' => 'public',
                'sslmode' => 'prefer',
            ]);

        foreach ($server->get() as $keyServer => $valServer) {
            #create Connection to client
            Config::set("database.connections.client", [
            // App::make('config')->set('database.connections.client', [
                'driver' => $valServer->db_con_driver,
                'host' => $valServer->db_con_host,
                'port' => $valServer->db_con_port,
                'database' => $valServer->db_con_dbname,
                'username' => $valServer->db_con_username,
                'password' => JangkrikHelper::customDecrypt($valServer->db_con_password),
                'charset' => 'utf8',
                'prefix' => '',
                'prefix_indexes' => true,
                'search_path' => 'public',
                'sslmode' => 'prefer',
            ]);
            $cekConn = Schema::connection('client')->hasTable('users');
            #get Schema Table From resource
            $clientSchema = Schema::connection('client')->getColumnListing('users');
            $pusatSchema = Schema::connection('pusat')->getColumnListing('users');
            $countPusat = count($pusatSchema);
            $countClient = count($clientSchema);
                    DB::connection('client')->statement("ALTER TABLE users ADD IF NOT EXISTS reset_token VARCHAR(255) NULL;");
                echo nl2br("{$valServer->db_con_location_name}: add users token Success!");

            // if (count($clientSchema) != count($pusatSchema)) {

            //     Schema::connection('client')->table('users', function (Blueprint $table) {
            //         $table->string('reset_token')->nullable();
            //     });
            //     echo nl2br("{$valServer->db_con_location_name}: add users token Success!");

            // }else{
            //     echo nl2br("{$valServer->db_con_location_name}: {$countPusat}:{$countClient} tabel user sama!");
            // }

            if ($cekConn) {
                // $status=0;
                try {
                    // DB::connection('client')->statement("TRUNCATE TABLE migrations RESTART IDENTITY;");
                    // DB::connection('client')->statement("
                    // INSERT INTO migrations (migration, batch) VALUES
                    // ('2014_10_12_000000_create_users_table', '1'),
                    // ('2014_10_12_100000_create_password_resets_table', '1'),
                    // ('2016_06_01_000001_create_oauth_auth_codes_table', '1'),
                    // ('2016_06_01_000002_create_oauth_access_tokens_table', '1'),
                    // ('2016_06_01_000003_create_oauth_refresh_tokens_table', '1'),
                    // ('2016_06_01_000004_create_oauth_clients_table', '1'),
                    // ('2016_06_01_000005_create_oauth_personal_access_clients_table', '1'),
                    // ('2019_08_19_000000_create_failed_jobs_table', '1'),
                    // ('2019_12_14_000001_create_personal_access_tokens_table', '1'),
                    // ('2022_11_03_091915_create_permission_tables', '1'),
                    // ('2022_11_04_071534_create_m_area_table', '1'),
                    // ('2022_11_05_103937_create_m_jenis_produk_table', '1'),
                    // ('2022_11_05_110856_create_m_plot_produksi_table', '1'),
                    // ('2022_11_07_133540_create_m_klasifikasi_produk_table', '1'),
                    // ('2022_11_07_133541_create_m_produk_table', '1'),
                    // ('2022_11_07_154029_create_m_jenis_nota_table', '1'),
                    // ('2022_11_07_154438_create_m_menu_harga_table', '1'),
                    // ('2022_11_07_164334_create_m_sub_jenis_produk_table', '1'),
                    // ('2022_11_07_164618_create_config_sub_jenis_produk_table', '1'),
                    // ('2022_11_07_170348_create_m_pajak_table', '1'),
                    // ('2022_11_07_170645_create_m_sc_table', '1'),
                    // ('2022_11_08_095139_create_m_w_jenis_table', '1'),
                    // ('2022_11_08_110025_create_m_modal_tipe_table', '1'),
                    // ('2022_11_08_110545_create_m_w_table', '1'),
                    // ('2022_11_09_060960_create_m_meja_jenis_table', '1'),
                    // ('2022_11_09_060961_create_m_meja_table', '1'),
                    // ('2022_11_09_060962_create_m_footer_table', '1'),
                    // ('2022_11_09_060963_create_m_transaksi_tipe_table', '1'),
                    // ('2022_11_09_060964_create_rekap_modal_table', '1'),
                    // ('2022_11_09_060965_create_m_payment_method_table', '1'),
                    // ('2022_11_09_060965_create_rekap_modal_detail_table', '1'),
                    // ('2022_11_09_060966_create_rekap_transaksi_table', '1'),
                    // ('2022_11_09_060967_create_rekap_transaksi_detail_table', '1'),
                    // ('2022_11_09_060968_create_rekap_buka_laci_table', '1'),
                    // ('2022_11_09_060970_create_rekap_garansi_table', '1'),
                    // ('2022_11_09_0609710_create_rekap_hapus_transaksi_detail_table', '1'),
                    // ('2022_11_09_0609711_create_rekap_lost_bill_detail_table', '1'),
                    // ('2022_11_09_060971_create_rekap_hapus_transaksi_table', '1'),
                    // ('2022_11_09_060972_create_rekap_lost_bill_table', '1'),
                    // ('2022_11_09_060974_create_rekap_mutasi_modal_table', '1'),
                    // ('2022_11_09_060975_create_rekap_payment_transaksi_table', '1'),
                    // ('2022_11_09_060976_create_rekap_hapus_menu_table', '1'),
                    // ('2022_11_09_060981_create_rekap_uang_tips_table', '1'),
                    // ('2022_11_09_060982_create_rekap_refund_table', '1'),
                    // ('2022_11_11_132150_create_m_karyawan_table', '1'),
                    // ('2022_11_12_090026_create_m_level_jabatan_table', '1'),
                    // ('2022_11_12_090333_create_m_jabatan_table', '1'),
                    // ('2022_11_12_092846_create_history_jabatan_table', '1'),
                    // ('2022_11_12_093418_create_history_pendidikan_table', '1'),
                    // ('2022_11_12_093419_create_m_kelompok_table', '1'),
                    // ('2022_11_12_093420_create_m_faq_kelompok_table', '1'),
                    // ('2022_11_12_093421_create_m_faq_table', '1'),
                    // ('2022_11_19_102237_create_m_satuan_table', '1'),
                    // ('2022_11_19_102850_create_m_resep_table', '1'),
                    // ('2022_11_23_103709_create_m_resep_detail_table', '1'),
                    // ('2022_12_03_165157_create_rekap_beli', '1'),
                    // ('2022_12_04_100520_create_m_rekening_table', '1'),
                    // ('2022_12_05_134440_create_rekap_beli_detail_table', '1'),
                    // ('2022_12_08_074850_create_tmp_transaction_table', '1'),
                    // ('2022_12_08_074851_create_tmp_transaction_detail_table', '1'),
                    // ('2022_12_09_133221_create_m_supplier_table', '1'),
                    // ('2022_12_10_082719_create_list_akt_table', '1'),
                    // ('2022_12_11_100242_create_rekap_rusak_table', '1'),
                    // ('2022_12_11_100330_create_rekap_rusak_detail_table', '1'),
                    // ('2022_12_14_090204_create_rekap_po_table', '1'),
                    // ('2022_12_14_090930_create_rekap_po_detail_table', '1'),
                    // ('2022_12_14_143140_create_rekap_inv_penjualan_table', '1'),
                    // ('2022_12_14_143246_create_rekap_inv_penjualan_detail_table', '1'),
                    // ('2022_12_24_085643_create_printer_setting_table', '1'),
                    // ('2022_12_26_105055_create_m_stok_table', '1'),
                    // ('2022_12_26_111630_create_m_stok_detail_table', '1'),
                    // ('2022_12_28_141015_create_m_gudang_table', '1'),
                    // ('2023_01_01_095955_create_m_kasir_akses_table', '1'),
                    // ('2023_01_14_084500_create_rekap_refund_detail_table', '1'),
                    // ('2023_01_17_135242_create_m_gudang_nama_table', '1'),
                    // ('2023_01_23_100905_create_m_jurnal_kas_table', '1'),
                    // ('2023_01_23_101925_create_m_jurnal_bank_table', '1'),
                    // ('2023_01_23_102356_create_m_jurnal_umum_table', '1'),
                    // ('2023_01_24_095858_create_rekap_tf_gudang', '1'),
                    // ('2023_02_17_140734_create_rekap_pcb_table', '1'),
                    // ('2023_02_20_164822_create_app_id_counter_table', '1'),
                    // ('2023_03_08_093413_create_m_divisi_table', '1'),
                    // ('2023_03_08_093414_create_m_group_produk_table', '1'),
                    // ('2023_03_09_140847_create_app_setting_table', '1'),
                    // ('2023_03_12_200129_create_rph_table', '1'),
                    // ('2023_03_12_203201_create_rph_detail_menu_table', '1'),
                    // ('2023_03_12_203533_create_rph_detail_bb_table', '1'),
                    // ('2023_03_15_132551_create_rekap_so_table', '1'),
                    // ('2023_03_15_132639_create_rekap_so_detail_table', '1'),
                    // ('2023_04_04_145018_create_rekap_member_table', '1'),
                    // ('2023_04_06_152157_create_log_transaksi_cr_table', '1'),
                    // ('2023_04_10_202222_add_rph_detail_bb_rph_detail_menu_id_column_to_rph_detail_bb_table', '2'),
                    // ('2023_04_14_131345_add_verified_to_users_table', '3'),
                    // ('2023_04_15_103909_alter_rph_change_mw', '4'),
                    // ('2023_04_15_153503_add_status_sync_master_cr', '4'),
                    // ('2023_04_17_114716_alter_m_divisi_table', '4'),
                    // ('2023_04_18_104851_add_std_bb_resep_konversi_table', '4'),
                    // ('2023_04_18_132858_alter_change_string_to_num_qty', '5'),
                    // ('2023_04_28_103255_create_log_cronjob_table', '5'),
                    // ('2023_04_28_142722_drop_and_create_rekap_jurnal_kas_table', '6'),
                    // ('2023_04_28_143454_drop_and_create_rekap_jurnal_bank_table', '6'),
                    // ('2023_04_28_143831_drop_and_create_rekap_jurnal_umum_table', '6'),
                    // ('2023_04_29_091648_drop_and_create_m_rekening__table', '6'),
                    // ('2023_04_29_104344_drop_and_create_m_link_akuntansi_table', '6'),
                    // ('2023_05_10_165738_create_cronjob_table', '6'),
                    // ('2023_05_17_095255_add_permision_status_sync_to_permission_table', '7'),
                    // ('2023_05_24_090551_alter_add_column_collect_status_mw_table', '8'),
                    // ('2023_05_26_141939_add_id_and_sync_to_sipedas_table', '8'),
                    // ('2023_05_29_112949_add_uniqueid_for_role', '9'),
                    // ('2023_05_30_173030_alter_m_std_bb_table_rev', '10'),
                    // ('2023_05_31_104013_create_rph_detail_belanja_table', '10'),
                    // ('2023_06_09_131015_create_ulang_table_sipedas', '11'),
                    // ('2023_06_11_145208_create_function_list_waroeng', '12'),
                    // ('2023_06_11_145209_add_field_master_control', '12'),
                    // ('2023_06_13_152245_drop_so_and_create_so_table', '12'),
                    // ('2023_06_23_110434_create_m_tipe_nota_table', '12'),
                    // ('2023_06_28_142239_add_field_selisih_on_transaksi', '12'),
                    // ('2023_07_06_102058_alter_table_role_has_permission_create_delete', '13'),
                    // ('2023_07_13_170600_alter_table_m_w_add_column', '14'),
                    // ('2023_07_15_093110_add_index_master', '15'),
                    // ('2023_07_20_132922_recreate_tmp_transaction_detail', '16'),
                    // ('2023_07_30_132602_alter_table_sipedas_add_pack_produk', '17'),
                    // ('2023_07_31_140419_drop_and_create_m_link_akuntansi_table', '17'),
                    // ('2023_08_03_170808_add_field_target_on_rekap', '18'),
                    // ('2023_08_10_133448_create_tmp_online_table', '18'),
                    // ('2023_08_10_133503_create_tmp_online_detail_table', '18'),
                    // ('2023_08_10_133504_add_reset_token_to_users', '19');");
                    // echo nl2br("{$valServer->db_con_location_name}: Replace Success!");

                    // Artisan::call("migrate --database='client'");
                    // echo nl2br("{$valServer->db_con_location_name}: ".Artisan::output());
                    // $DbCron->table('db_con')->where('db_con_id',$valServer->db_con_id)
                    // ->update([
                    //     'db_con_schema_status' => 'latest'
                    // ]);
                    // $status=1;
                } catch (\Throwable $th) {
                    printf($th);
                    // $status=0;
                }

                // if ($status == 1) {
                //     echo "{$valServer->db_con_location_name} update Success!\n";
                //     $DbCron->table('db_con')->where('db_con_id',$valServer->db_con_id)
                //     ->update([
                //         'db_con_schema_status' => 'latest'
                //     ]);
                // }else{
                //     echo "{$valServer->db_con_location_name} update FAILED!\n";
                //     $DbCron->table('db_con')->where('db_con_id',$valServer->db_con_id)
                //     ->update([
                //         'db_con_schema_status' => 'expired'
                //     ]);
                // }
            }
        }

        return response("DONE!!");
    }
}
