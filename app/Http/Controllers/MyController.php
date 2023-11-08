<?php

namespace App\Http\Controllers;

use App\Helpers\JangkrikHelper;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

class MyController extends Controller
{
    public function sendMaster($target)
    {
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
                $expTarget = explode("-", $target);
                $newTarget = '';
                foreach ($expTarget as $key => $valTarget) {
                    $newTarget .= ':' . $valTarget . ':';
                }
                $finalTarget = DB::raw($valTable . "_client_target||'{$newTarget}'");
            } else {
                $finalTarget = DB::raw('DEFAULT');
            }

            $fieldName = $valTable . "_client_target";
            DB::table($valTable)
                ->update([
                    $fieldName => $finalTarget,
                ]);
        }

        DB::table('roles')
            ->update([
                'roles_client_target' => ($target != "all") ? DB::raw("roles_client_target||'{$newTarget}'") : DB::raw('DEFAULT'),
            ]);

        DB::table('permissions')
            ->update([
                'permissions_client_target' => ($target != "all") ? DB::raw("permissions_client_target||'{$newTarget}'") : DB::raw('DEFAULT'),
            ]);

        DB::table('role_has_permissions')
            ->update([
                'r_h_p_client_target' => ($target != "all") ? DB::raw("r_h_p_client_target||'{$newTarget}'") : DB::raw('DEFAULT'),
            ]);

        DB::table('model_has_permissions')
            ->update([
                'm_h_p_client_target' => ($target != "all") ? DB::raw("m_h_p_client_target||'{$newTarget}'") : DB::raw('DEFAULT'),
            ]);

        DB::table('model_has_roles')
            ->update([
                'm_h_r_client_target' => ($target != "all") ? DB::raw("m_h_r_client_target||'{$newTarget}'") : DB::raw('DEFAULT'),
            ]);

        DB::table('m_transaksi_tipe')
            ->update([
                'm_t_t_client_target' => ($target != "all") ? DB::raw("m_t_t_client_target||'{$newTarget}'") : DB::raw('DEFAULT'),
            ]);

        return "DONE";
    }

    public function sendRekap($mw,$start,$end)
    {
        #Rekap
        DB::statement("UPDATE rekap_buka_laci SET WHERE SPLIT_PART() = '{$mw}';");
        DB::statement("UPDATE rekap_garansi SET WHERE SPLIT_PART() = '{$mw}';");
        DB::statement("UPDATE rekap_hapus_menu SET WHERE SPLIT_PART() = '{$mw}';");
        DB::statement("UPDATE rekap_hapus_transaksi SET WHERE SPLIT_PART() = '{$mw}';");
        DB::statement("UPDATE rekap_hapus_transaksi_detail SET WHERE SPLIT_PART() = '{$mw}';");
        DB::statement("UPDATE rekap_lost_bill SET WHERE SPLIT_PART() = '{$mw}';");
        DB::statement("UPDATE rekap_lost_bill_detail SET WHERE SPLIT_PART() = '{$mw}';");
        DB::statement("UPDATE rekap_member SET WHERE SPLIT_PART() = '{$mw}';");
        DB::statement("UPDATE rekap_modal SET WHERE SPLIT_PART() = '{$mw}';");
        DB::statement("UPDATE rekap_modal_detail SET WHERE SPLIT_PART() = '{$mw}';");
        DB::statement("UPDATE rekap_mutasi_modal SET WHERE SPLIT_PART() = '{$mw}';");
        DB::statement("UPDATE rekap_uang_tips SET WHERE SPLIT_PART() = '{$mw}';");
        DB::statement("UPDATE rekap_transaksi SET WHERE SPLIT_PART() = '{$mw}';");
        DB::statement("UPDATE rekap_transaksi_detail SET WHERE SPLIT_PART() = '{$mw}';");
        DB::statement("UPDATE rekap_payment_transaksi SET WHERE SPLIT_PART() = '{$mw}';");
        DB::statement("UPDATE rekap_refund SET WHERE SPLIT_PART() = '{$mw}';");
        DB::statement("UPDATE rekap_refund_detail SET WHERE SPLIT_PART() = '{$mw}';");
    }

    public function uploadImage()
    {
        #Send Image to public server
        $img = url("/struct/lele.jpeg");
        $folder = 'produk';

        $image = fopen($img, 'r');
        $upload = Http::withHeaders([
            'accept' => 'application/json',
            'X-Authorization' => 'aD1UnchysFUfRHMqi61TWiZT7gjAFNAmnDrjkUFvVgrXIJplWasWvylDuZismZnO',
        ])
            ->attach('image', $image)
            ->post('https://struk.pedasabis.com/api/upload-image', [
                "folder" => $folder,
            ]);
        return response($upload, 200);
    }

    public function deleteImage()
    {
        $urlImage = "https://struk.pedasabis.com/storage/produk/tes.jpg";
        #delete image from cloud storage
        $delete = Http::withHeaders([
            'accept' => 'application/json',
            'X-Authorization' => 'aD1UnchysFUfRHMqi61TWiZT7gjAFNAmnDrjkUFvVgrXIJplWasWvylDuZismZnO',
        ])
            ->post('https://struk.pedasabis.com/api/delete-image', [
                "url" => $urlImage,
            ]);
        return response($delete, 200);
    }

    public function upgradeDb($target)
    {
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
            ->where('db_con_sync_status', 'on')
            ->whereNotIn('db_con_id', ['1'])
            ->orderBy('db_con_id', 'asc');
        if ($target != "all") {
            $server->where('db_con_m_w_id', $target);
        }

        foreach ($server->get() as $keyServer => $valServer) {
            #create Connection to client
            $clientName = "client{$valServer->db_con_m_w_id}";
            Config::set("database.connections.{$clientName}", [
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
            $cekConn = Schema::connection($clientName)->hasTable('users');

            if ($cekConn) {
                $status=0;
                try {
                    // return $clientName;
                    Artisan::call("migrate --database='{$clientName}'");
                    echo nl2br("{$valServer->db_con_location_name}: ".Artisan::output());
                    // $DbCron->table('db_con')->where('db_con_id',$valServer->db_con_id)
                    // ->update([
                    //     'db_con_schema_status' => 'latest'
                    // ]);
                    $status=1;
                } catch (\Throwable $th) {
                    printf($th);
                    $status=0;
                }

                if ($status == 1) {
                    echo "{$valServer->db_con_location_name} update Success!\n";
                    $DbCron->table('db_con')->where('db_con_id',$valServer->db_con_id)
                    ->update([
                        'db_con_schema_status' => 'latest'
                    ]);
                }else{
                    echo "{$valServer->db_con_location_name} update FAILED!\n";
                    $DbCron->table('db_con')->where('db_con_id',$valServer->db_con_id)
                    ->update([
                        'db_con_schema_status' => 'expired'
                    ]);
                }
            }
        }

        return response("DONE!!");
    }
}
