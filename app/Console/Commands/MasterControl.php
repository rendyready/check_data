<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class MasterControl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mastercontrol:cron';

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
    public function handle()
    {
        #Cek cronjob status
        $cronStatus = DB::table('cronjob')
                    ->where('cronjob_name','mastercontrol:cron')
                    ->first();

        if ($cronStatus->cronjob_status == 'open') {
            info("Cronjob Master Controlling START at ". Carbon::now()->format('Y-m-d H:i:s'));
        }else{
            return Command::SUCCESS;
        }

        #get source
        $getSourceConn = DB::table('db_con')
            ->where('db_con_location','pusat')
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
                $DbPusat = DB::connection('source');

                DB::table('db_con')->where('db_con_id',$getSourceConn->db_con_id)
                    ->update([
                        'db_con_network_status' => $status
                    ]);
            }

        } catch (\Exception $e) {
            Log::info("MasterControll:Cron Could not connect to the SOURCE database. Error:" . $e);
            DB::table('db_con')->where('db_con_id',$getSourceConn->db_con_id)
            ->update([
                'db_con_network_status' => 'disconnect'
            ]);
            exit();
        }

        #GET Data is open?
        $getCronOpen = $DbPusat->table('cronjob')
            ->where('cronjob_name','mastercontrol:cron')
            ->first();

        if ($getCronOpen->cronjob_status == 'close') {
            Log::alert("MASTER CONTROL NOT ALLOWED. SERVER BUSY.");
            exit();
        }

        #GET Destination
        $dest = DB::table('db_con')->whereIn('db_con_location',['waroeng','area'])
        ->first();

        Config::set("database.connections.destination", [
            'driver' => $dest->db_con_driver,
            'host' => $dest->db_con_host,
            'port' => $dest->db_con_port,
            'database' => $dest->db_con_dbname,
            'username' => $dest->db_con_username,
            'password' => Helper::customDecrypt($dest->db_con_password),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ]);

        try {
            $cekConn = Schema::connection('destination')->hasTable('users');

            $status = '';
            if ($cekConn) {
                $status = 'connect';
                $DbLocal = DB::connection('destination');
                DB::table('db_con')->where('db_con_id',$dest->db_con_id)
                ->update([
                    'db_con_network_status' => $status
                ]);
            }

        } catch (\Exception $e) {
            Log::info("MasterControll:Cron Could not connect to Destination. Error:" . $e);
            DB::table('db_con')->where('db_con_id',$dest->db_con_id)
                ->update([
                    'db_con_network_status' => 'disconnect'
                ]);
            #skip executing on error connection
            exit();
        }

        $getTableList = DB::table('config_get_data')
                        ->where('config_get_data_status','on')
                        ->orderBy('config_get_data_id','desc')
                        ->get();
        foreach ($getTableList as $key => $valTab) {
            #get Schema Table From resource
            $sourceSchema = Schema::connection('source')->getColumnListing($valTab->config_get_data_table_name);
            $destSchema = Schema::connection('destination')->getColumnListing($valTab->config_get_data_table_name);
            if (count($sourceSchema) != count($destSchema)) {
                info("DB structur of DESTINATION EXPIRED");
                #SKIP
                exit();
            }

            #comparing data lokal <-> pusat
            $getLocal = $DbLocal->table($valTab->config_get_data_table_name)->get();
            $fieldId = $valTab->config_get_data_field_validate1;
            $dataLocal = [];
            foreach ($getLocal as $key => $value) {
                array_push($dataLocal,$value->$fieldId);
            }

            $getPusat = $DbPusat->table($valTab->config_get_data_table_name)->get();
            $fieldId = $valTab->config_get_data_field_validate1;
            $dataPusat = [];
            foreach ($getPusat as $key => $value) {
                array_push($dataPusat,$value->$fieldId);
            }

            $notExist = array_diff($dataLocal,$dataPusat);

            if (count($notExist) > 0) {
                try {
                    $DbLocal->table($valTab->config_get_data_table_name)
                    ->whereIn($fieldId,$notExist)
                    ->delete();
                } catch (\Throwable $th) {
                    Log::alert("Can't delete data from {$valTab->config_get_data_table_name}");
                    Log::info($th);
                }
            }

            #Local Log
            DB::table('log_cronjob')
            ->insert([
                'log_cronjob_name' => 'mastercontrol:cron',
                'log_cronjob_from_server_id' => $getSourceConn->db_con_m_w_id,
                'log_cronjob_from_server_name' => $getSourceConn->db_con_location_name,
                'log_cronjob_to_server_id' => $dest->db_con_m_w_id,
                'log_cronjob_to_server_name' => $dest->db_con_location_name,
                'log_cronjob_datetime' => Carbon::now(),
                'log_cronjob_note' => $valTab->config_get_data_table_name.'-CHECKED!',
            ]);

            // #Cek Last Sync
            // $lastId = DB::table('log_data_sync')
            //             ->where('log_data_sync_cron','mastercontrol:cron')
            //             ->where('log_data_sync_table',$valTab->config_get_data_table_name)
            //             ->first();

            // #GET Local
            // $getDataLocal = $DbLocal->table($valTab->config_get_data_table_name);
            // if (!empty($lastId)) {
            //     $getDataLocal->where($valTab->config_get_data_field_validate1,'>=',$lastId->log_data_sync_last);
            // }
            // $getDataLocal->orderBy($valTab->config_get_data_field_validate1,'asc');
            // $getDataLocal->limit(100);

            // // if ($valTab->config_get_data_limit > 0) {
            // //     $getDataLocal->limit($valTab->config_get_data_limit);
            // // }

            // #remove local master where not in server
            // if ($getDataLocal->get()->count() > 0) {
            //     $nextLast = 0;
            //     foreach ($getDataLocal->get() as $keyDataLocal => $valDataLocal) {
            //         try {
            //             $validateField = $valTab->config_get_data_field_validate1;
            //             $dataExist = $DbPusat->table($valTab->config_get_data_table_name)
            //                         ->where($valTab->config_get_data_field_validate1,$valDataLocal->$validateField)->get();

            //             $id = $valDataLocal->$validateField;
            //             if ($dataExist->count() < 1) {
            //                 $DbLocal->table($valTab->config_get_data_table_name)
            //                         ->where($valTab->config_get_data_field_validate1,$id)
            //                         ->delete();
            //             }

            //             $nextLast = $id;
            //         } catch (\Throwable $th) {
            //             Log::alert("Can't delete data from {$valTab->config_get_data_table_name}");
            //             Log::info($th);
            //         }
            //     }
            //     if ($nextLast != 0) {
            //         $validateField = $valTab->config_get_data_field_validate1;
            //         $firstId = $DbLocal->table($valTab->config_get_data_table_name)
            //             ->orderBy($valTab->config_get_data_field_validate1,'asc')
            //             ->first()->$validateField;

            //         $endId = $DbLocal->table($valTab->config_get_data_table_name)
            //             ->orderBy($valTab->config_get_data_field_validate1,'desc')
            //             ->first()->$validateField;

            //         if ($nextLast == $endId) {
            //             $nextLast = $firstId;
            //         }

            //         DB::table('log_data_sync')
            //             ->updateOrInsert(
            //             [
            //                 'log_data_sync_cron' => 'mastercontrol:cron',
            //                 'log_data_sync_table' => $valTab->config_get_data_table_name,
            //             ],
            //             [
            //                 'log_data_sync_cron' => 'mastercontrol:cron',
            //                 'log_data_sync_table' => $valTab->config_get_data_table_name,
            //                 'log_data_sync_last' => $nextLast,
            //                 'log_data_sync_note' => 'ok'
            //             ]
            //         );
            //         #Local Log
            //         DB::table('log_cronjob')
            //         ->insert([
            //             'log_cronjob_name' => 'mastercontrol:cron',
            //             'log_cronjob_from_server_id' => $getSourceConn->db_con_m_w_id,
            //             'log_cronjob_from_server_name' => $getSourceConn->db_con_location_name,
            //             'log_cronjob_to_server_id' => $dest->db_con_m_w_id,
            //             'log_cronjob_to_server_name' => $dest->db_con_location_name,
            //             'log_cronjob_datetime' => Carbon::now(),
            //             'log_cronjob_note' => $valTab->config_get_data_table_name.'-CHECKED!',
            //         ]);
            //     }
            // }
        }

        Log::info("Cronjob Master Controlling FINISH at ". Carbon::now()->format('Y-m-d H:i:s'));
        return Command::SUCCESS;
    }
}
