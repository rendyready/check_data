<?php

namespace App\Http\Controllers;

use App\Helpers\JangkrikHelper;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ControlDataController extends Controller
{
    public function CountData()
    {
        #Create Connection To Cronjob DB
        Config::set("database.connections.cronjob", [
            'driver' => 'pgsql',
            'host' => '192.168.88.4',
            'port' => '5432',
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

        $sipedasPusat = $DbCron->table('db_con')
            ->where('db_con_id', '1')->first();
        Config::set("database.connections.cronjob", [
            // App::make('config')->set('database.connections.client', [
            'driver' => $sipedasPusat->db_con_driver,
            'host' => '192.168.88.4',
            'port' => '5432',
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
            $cekConn = Schema::connection('cronjob')->hasTable('users');
            #get Schema Table From resource
            $clientSchema = Schema::connection('cronjob')->getColumnListing('users');
            $pusatSchema = Schema::connection('cronjob')->getColumnListing('users');
            $countPusat = count($pusatSchema);
            $countClient = count($clientSchema);
            try {

                $data = [
                    'rekap_buka_laci' . $valServer->db_con_location_name => DB::connection('client')->table('rekap_buka_laci')
                        ->whereBetween('r_b_l_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_buka_laci_pusat' . $valServer->db_con_location_name => DB::connection('pusat')->table('rekap_buka_laci')
                        ->whereBetween('r_b_l_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_garansi' . $valServer->db_con_location_name => DB::connection('client')->table('rekap_garansi')
                        ->join('rekap_transaksi', 'r_t_id', 'rekap_garansi_r_t_id')
                        ->whereBetween('r_t_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_garansi' . $valServer->db_con_location_name => DB::connection('pusat')->table('rekap_garansi')
                        ->join('rekap_transaksi', 'r_t_id', 'rekap_garansi_r_t_id')
                        ->whereBetween('r_t_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_hapus_menu' . $valServer->db_con_location_name => DB::connection('client')->table('rekap_hapus_menu')
                        ->whereBetween('r_h_m_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_hapus_menu' . $valServer->db_con_location_name => DB::connection('pusat')->table('rekap_hapus_menu')
                        ->whereBetween('r_h_m_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_hapus_transaksi' . $valServer->db_con_location_name => DB::connection('client')->table('rekap_hapus_transaksi')
                        ->whereBetween('r_h_t_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_hapus_transaksi' . $valServer->db_con_location_name => DB::connection('pusat')->table('rekap_hapus_transaksi')
                        ->whereBetween('r_h_t_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_hapus_transaksi_detail' . $valServer->db_con_location_name => DB::connection('client')->table('rekap_hapus_transaksi_detail')
                        ->join('rekap_hapus_transaksi', 'r_h_t_id', 'r_h_t_detail_r_h_t_id')
                        ->whereBetween('r_h_t_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_hapus_transaksi_detail' . $valServer->db_con_location_name => DB::connection('cliepusatnt')->table('rekap_hapus_transaksi_detail')
                        ->join('rekap_hapus_transaksi', 'r_h_t_id', 'r_h_t_detail_r_h_t_id')
                        ->whereBetween('r_h_t_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_lost_bill' . $valServer->db_con_location_name => DB::connection('client')->table('rekap_lost_bill')
                        ->whereBetween('r_l_b_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_lost_bill' . $valServer->db_con_location_name => DB::connection('pusat')->table('rekap_lost_bill')
                        ->whereBetween('r_l_b_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_lost_bill_detail' . $valServer->db_con_location_name => DB::connection('client')->table('rekap_lost_bill_detail')
                        ->join('rekap_lost_bill', 'r_l_b_id', 'r_l_b_detail_r_l_b_id')
                        ->whereBetween('r_l_b_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_lost_bill_detail' . $valServer->db_con_location_name => DB::connection('pusat')->table('rekap_lost_bill_detail')
                        ->join('rekap_lost_bill', 'r_l_b_id', 'r_l_b_detail_r_l_b_id')
                        ->whereBetween('r_l_b_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_modal' . $valServer->db_con_location_name => DB::connection('client')->table('rekap_modal')
                        ->whereBetween(DB::raw('DATE(rekap_modal_tanggal)'), ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_modal' . $valServer->db_con_location_name => DB::connection('pusat')->table('rekap_modal')
                        ->whereBetween(DB::raw('DATE(rekap_modal_tanggal)'), ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_modal_detail' . $valServer->db_con_location_name => DB::connection('client')->table('rekap_modal_detail')
                        ->join('rekap_modal', 'rekap_modal_id', 'rekap_modal_detail_rekap_modal_id')
                        ->whereBetween(DB::raw('DATE(rekap_modal_tanggal)'), ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_modal_detail' . $valServer->db_con_location_name => DB::connection('pusat')->table('rekap_modal_detail')
                        ->join('rekap_modal', 'rekap_modal_id', 'rekap_modal_detail_rekap_modal_id')
                        ->whereBetween(DB::raw('DATE(rekap_modal_tanggal)'), ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_mutasi_modal' . $valServer->db_con_location_name => DB::connection('client')->table('rekap_mutasi_modal')
                        ->whereBetween('r_m_m_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_mutasi_modal' . $valServer->db_con_location_name => DB::connection('pusat')->table('rekap_mutasi_modal')
                        ->whereBetween('r_m_m_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_payment_transaksi' . $valServer->db_con_location_name => DB::connection('client')->table('rekap_payment_transaksi')
                        ->join('rekap_transaksi', 'r_t_id', 'r_p_t_r_t_id')
                        ->whereBetween('r_t_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_payment_transaksi' . $valServer->db_con_location_name => DB::connection('pusat')->table('rekap_payment_transaksi')
                        ->join('rekap_transaksi', 'r_t_id', 'r_p_t_r_t_id')
                        ->whereBetween('r_t_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_refund' . $valServer->db_con_location_name => DB::connection('client')->table('rekap_refund')
                        ->whereBetween('r_r_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_refund' . $valServer->db_con_location_name => DB::connection('pusat')->table('rekap_refund')
                        ->whereBetween('r_r_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_refund_detail' . $valServer->db_con_location_name => DB::connection('client')->table('rekap_refund_detail')
                        ->join('rekap_refund', 'r_r_id', 'r_r_detail_r_r_id')
                        ->whereBetween('r_r_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_refund_detail' . $valServer->db_con_location_name => DB::connection('pusat')->table('rekap_refund_detail')
                        ->join('rekap_refund', 'r_r_id', 'r_r_detail_r_r_id')
                        ->whereBetween('r_r_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_transaksi' . $valServer->db_con_location_name => DB::connection('client')->table('rekap_transaksi')
                        ->whereBetween('r_t_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_transaksi' . $valServer->db_con_location_name => DB::connection('pusat')->table('rekap_transaksi')
                        ->whereBetween('r_t_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_transaksi_detail' . $valServer->db_con_location_name => DB::connection('client')->table('rekap_transaksi_detail')
                        ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
                        ->whereBetween('r_t_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),

                    'rekap_transaksi_detail' . $valServer->db_con_location_name => DB::connection('pusat')->table('rekap_transaksi_detail')
                        ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
                        ->whereBetween('r_t_tanggal', ['2023-10-01', '2023-10-10'])
                        ->count(),
                ];

            } catch (\Throwable $th) {
                return $th;
            }
        }
        return $data;
    }
}
