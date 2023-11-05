<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class CountDataServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'countdataserver:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function count_data()
    {
        #Cek cronjob status
        $cronStatus = DB::table('cronjob')
            ->where('cronjob_name', 'countdataserver:cron')
            ->first();
        if ($cronStatus->cronjob_status == 'open') {
            info("Cronjob Count Data Server START at " . Carbon::now()->format('Y-m-d H:i:s'));
        } else {
            return Command::SUCCESS;
        }

        #get source
        $getSourceConn = DB::table('db_con')
            ->where('db_con_location', 'pusat')
            ->first();

        Config::set("database.connections.source", [
            'driver' => $getSourceConn->db_con_driver,
            'host' => $getSourceConn->db_con_host,
            'port' => $getSourceConn->db_con_port,
            'database' => $getSourceConn->db_con_dbname,
            'username' => $getSourceConn->db_con_username,
            'password' => Helper::customDecrypt($getSourceConn->db_con_password),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ]);

        try {
            $cekConn = Schema::connection('source')->hasTable('users');

            $status = '';
            if ($cekConn) {
                $status = 'connect';
                $DbSource = DB::connection('source');

                DB::table('db_con')->where('db_con_id', $getSourceConn->db_con_id)
                    ->update([
                        'db_con_network_status' => $status,
                    ]);
            }
        } catch (\Exception $e) {
            info("Could not connect to the SOURCE database. Error:" . $e);
            DB::table('db_con')->where('db_con_id', $getSourceConn->db_con_id)
                ->update([
                    'db_con_network_status' => 'disconnect',
                ]);
            exit();
        }

        $getlist_master = DB::table('config_get_data')
            ->orderBy('config_get_data_id', 'asc')
            ->get();
        $getlist_rekap = DB::table('config_sync')
            ->orderBy('config_sync_id', 'asc')
            ->where('config_sync_table_tipe', 'transaksi')
            ->get();
        $today = Carbon::now();
        // Mendapatkan tanggal kemarin
        $yesterday = $today->subDay();
        // Memformat tanggal kemarin menjadi "230713"
        $tanggal = $yesterday->format('ymd');
        // Get Destination Berdasarkan Log tidak Connet
        $getlist_dest = $DbSource->table('log_data_count')
            ->where('log_data_count_tabel_nama', '!=', 'disconnect')
            ->where('log_data_count_tanggal', $yesterday)
            ->groupBy('log_data_count_m_w_id')
            ->pluck('log_data_count_m_w_id')
            ->toArray();

        #GET Destination
        $dest = DB::table('db_con')->whereIn('db_con_location', ['waroeng', 'area'])
            ->where('db_con_host', '!=', 'null')
            ->where('db_con_sync_status', 'aktif')
            ->whereNotIn('db_con_m_w_id', $getlist_dest)
            ->orderBy('db_con_id', 'ASC')
            ->get();
        foreach ($dest as $key => $valDest) {
            $connName = "dest{$valDest->db_con_m_w_id}";
            Config::set("database.connections.{$connName}", [
                'driver' => $valDest->db_con_driver,
                'host' => $valDest->db_con_host,
                'port' => $valDest->db_con_port,
                'database' => $valDest->db_con_dbname,
                'username' => $valDest->db_con_username,
                'password' => Helper::customDecrypt($valDest->db_con_password),
                'charset' => 'utf8',
                'prefix' => '',
                'prefix_indexes' => true,
                'search_path' => 'public',
                'sslmode' => 'prefer',
            ]);

            try {
                $cekConn = Schema::connection($connName)->hasTable('users');

                $status = '';
                if ($cekConn) {
                    $status = 'connect';
                    $DbDest = DB::connection($connName);
                    DB::table('db_con')->where('db_con_id', $valDest->db_con_id)
                        ->update([
                            'db_con_network_status' => $status,
                        ]);
                }
            } catch (\Exception $e) {

                // die("Could not connect to the database. Error:" . $e );
                info("Could not connect to Destination {$valDest->db_con_location_name}. Error:" . $e);
                DB::table('db_con')->where('db_con_id', $valDest->db_con_id)
                    ->update([
                        'db_con_network_status' => 'disconnect',
                    ]);
                $datacon = [
                    'log_data_count_m_w_id' => $valDest->db_con_m_w_id,
                    'log_data_count_m_w_nama' => $valDest->db_con_location_name,
                    'log_data_count_tabel_nama' => "disconnet",
                    'log_data_count_pusat' => 0,
                    'log_data_count_waroeng' => 0,
                    'log_data_count_tanggal' => $yesterday,
                ];
                $DbSource->table('log_data_count')->insert($datacon);
                #skip executing on error connection
                continue;
            }

            foreach ($getlist_master as $master) {
                #get Schema Table From resource
                $sourceSchema = Schema::connection('source')->getColumnListing($master->config_get_data_table_name);
                $destSchema = Schema::connection($connName)->getColumnListing($master->config_get_data_table_name);
                if (count($sourceSchema) != count($destSchema)) {
                    info("DB structur of master {$valDest->db_con_location_name} EXPIRED");
                    #SKIP
                    continue;
                }
                $countsource = $DbSource->table($master->config_get_data_table_name)
                    ->count($master->config_get_data_field_validate1);
                $countdest = $DbDest->table($master->config_get_data_table_name)
                    ->count($master->config_get_data_field_validate1);
                if ($countsource != $countdest) {
                    $data = [
                        'log_data_count_m_w_id' => $valDest->db_con_m_w_id,
                        'log_data_count_m_w_nama' => $valDest->db_con_location_name,
                        'log_data_count_tabel_nama' => $master->config_get_data_table_name,
                        'log_data_count_pusat' => $countsource,
                        'log_data_count_waroeng' => $countdest,
                        'log_data_count_tanggal' => $yesterday,
                    ];
                    $DbSource->table('log_data_count')->insert($data);
                }
            }
            foreach ($getlist_rekap as $rekap) {
                #get Schema Table From resource
                $sourceSchema = Schema::connection('source')->getColumnListing($rekap->config_sync_table_name);
                $destSchema = Schema::connection($connName)->getColumnListing($rekap->config_sync_table_name);
                if (count($sourceSchema) != count($destSchema)) {
                    info("DB structur of rekap {$valDest->db_con_location_name} EXPIRED");
                    #SKIP
                    continue;
                }

                $countsource = $DbSource->table($rekap->config_sync_table_name)
                    ->where(DB::raw("SPLIT_PART(" . $rekap->config_sync_field_validate1 . ", '.', 2)"), '=', "$valDest->db_con_m_w_id")
                    ->where(DB::raw("LEFT(SPLIT_PART(" . $rekap->config_sync_field_validate1 . ", '.', 5), 6)"), '=', "$tanggal")
                    ->count();
                $countdest = $DbDest->table($rekap->config_sync_table_name)
                    ->where(DB::raw("SPLIT_PART(" . $rekap->config_sync_field_validate1 . ", '.', 2)"), '=', "$valDest->db_con_m_w_id")
                    ->where(DB::raw("LEFT(SPLIT_PART(" . $rekap->config_sync_field_validate1 . ", '.', 5), 6)"), '=', "$tanggal")
                    ->count();
                if ($countsource != $countdest) {
                    $data = [
                        'log_data_count_m_w_id' => $valDest->db_con_m_w_id,
                        'log_data_count_m_w_nama' => $valDest->db_con_location_name,
                        'log_data_count_tabel_nama' => $rekap->config_sync_table_name,
                        'log_data_count_pusat' => $countsource,
                        'log_data_count_waroeng' => $countdest,
                        'log_data_count_tanggal' => $yesterday,
                    ];
                    $DbSource->table('log_data_count')->insert($data);
                }
            }
        }

        Log::info("Cronjob Count Data Server FINISH at " . Carbon::now()->format('Y-m-d H:i:s'));
        return Command::SUCCESS;
    }
}
