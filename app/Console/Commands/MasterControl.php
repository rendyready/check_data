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
    protected $signature = 'mastercontroll:cron';

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
                    ->where('cronjob_name','mastercontroll:cron')
                    ->first();

        if (!empty($cronStatus)) {
            if ($cronStatus->cronjob_status == 'open') {
                Log::info("Cronjob MASTER CONTROL START at ". Carbon::now()->format('Y-m-d H:i:s'));
            }else{
                Log::info("Cronjob MASTER CONTROL CLOSED");
                return Command::SUCCESS;
            }
        }else{
            Log::info("Cronjob MASTER CONTROL CLOSED");
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
            return Command::SUCCESS;
        }

        #GET Local Connection
        $dest = DB::table('db_con')
        ->where('db_con_host','127.0.0.1')
        ->first();

        if (empty($dest)) {
            Log::info("Cronjob MASTER CONTROL, LOCAL DB NOT ACTIVE");
            return Command::SUCCESS;
        }

        #SYNC Data is open from this local?
        $getDataOpen = DB::connection('cronpusat')
            ->table('db_con')
            ->where('db_con_m_w_id',$dest->db_con_m_w_id)
            ->first();

        if (!empty($getDataOpen)) {
            if ($getDataOpen->db_con_sync_status == 'off') {
                Log::alert("MASTER CONTROL NOT ALLOWED FROM PUSAT. SERVER BUSY.");
                return Command::SUCCESS;
            }
        }else{
            Log::alert("MASTER CONTROL SETUP NOT FOUND.");
            return Command::SUCCESS;
        }

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
            return Command::SUCCESS;
        }

        $getTableList = DB::connection('cronpusat')
            ->table('config_sync')
            ->where('config_sync_tipe','mastercontroll')
            ->where('config_sync_status','on')
            ->orderBy('config_sync_id','asc')
            ->get();

        foreach ($getTableList as $key => $valTab) {
            #get Schema Table From resource
            $sourceSchema = Schema::connection('source')->getColumnListing($valTab->config_sync_table_name);
            $destSchema = Schema::connection('destination')->getColumnListing($valTab->config_sync_table_name);
            if (count($sourceSchema) != count($destSchema)) {
                info("CRON MASTER CONTROLL - Table {$valTab->config_sync_table_name} Schema not suitable ");
                #SKIP
                continue;
            }

            #comparing data lokal <-> pusat
            $countLocal = $DbLocal->table($valTab->config_sync_table_name)->count();
            $countPusat = $DbPusat->table($valTab->config_sync_table_name)->count();

            if ($countLocal > $countPusat) {
                #CONTROLL-CHECK
                $DbLocal->table($valTab->config_sync_table_name)->orderBy($valTab->config_sync_field_pkey,'asc')->chunk($valTab->config_sync_limit, function ($chunks) use ($DbLocal,$DbPusat,$valTab) {

                    foreach ($chunks as $valchunk) {
                        $pkey = $valTab->config_sync_field_pkey;
                        $cek = $DbPusat->table($valTab->config_sync_table_name)
                                ->where($valTab->config_sync_field_pkey,$valchunk->$pkey)
                                ->count();
                        if ($cek == 0) {
                            try {
                                $DbLocal->table($valTab->config_sync_table_name)
                                    ->where($valTab->config_sync_field_pkey,$valchunk->$pkey)
                                    ->delete();
                                    Log::alert("CRON MASTER CONTROLL : Deleted id {$valchunk->$pkey} from {$valTab->config_sync_table_name}");
                            } catch (\Throwable $th) {
                                Log::alert("Error: ".$th);
                            }
                        }
                    }
                });
            }elseif($countLocal < $countPusat){
                #CONTROLL-GET
                $DbPusat->table($valTab->config_sync_table_name)->orderBy($valTab->config_sync_field_pkey,'asc')->chunk($valTab->config_sync_limit, function ($chunks) use ($DbLocal,$DbPusat,$valTab,$sourceSchema) {

                    foreach ($chunks as $valchunk) {
                        $pkey = $valTab->config_sync_field_pkey;
                        $cek = $DbLocal->table($valTab->config_sync_table_name)
                                ->where($valTab->config_sync_field_pkey,$valchunk->$pkey)
                                ->count();
                        if ($cek == 0) {
                            $newDestStatus = "";
                            $data = [];
                            foreach ($sourceSchema as $keySchema => $valSchema) {
                                if ($valSchema != 'id') {
                                    if ($valSchema == $valTab->config_sync_field_status) {
                                        $data[$valSchema] = $newDestStatus;
                                    } else {
                                        $data[$valSchema] = $valchunk->$valSchema;
                                    }
                                }
                            }
                            try {
                                $DbLocal->table($valTab->config_sync_table_name)
                                    ->insert($data);
                                    Log::alert("CRON MASTER CONTROLL : Insert New Data {$valchunk->$pkey} to {$valTab->config_sync_table_name}");
                            } catch (\Throwable $th) {
                                Log::alert("Error: ".$th);
                            }
                        }
                    }
                });
            }else{
                Log::info("CRON MASTER CONTROLL: Table {$valTab->config_sync_table_name} is GOOD!");
            }

            // $getLocal = $DbLocal->table($valTab->config_get_data_table_name)->get();
            // $fieldId = $valTab->config_get_data_field_validate1;
            // $dataLocal = [];
            // foreach ($getLocal as $key => $value) {
            //     array_push($dataLocal,$value->$fieldId);
            // }

            // $getPusat = $DbPusat->table($valTab->config_get_data_table_name)->get();
            // $fieldId = $valTab->config_get_data_field_validate1;
            // $dataPusat = [];
            // foreach ($getPusat as $key => $value) {
            //     array_push($dataPusat,$value->$fieldId);
            // }

            // $notExist = array_diff($dataLocal,$dataPusat);

            // if (count($notExist) > 0) {
            //     try {
            //         $DbLocal->table($valTab->config_get_data_table_name)
            //         ->whereIn($fieldId,$notExist)
            //         ->delete();
            //     } catch (\Throwable $th) {
            //         Log::alert("Can't delete data from {$valTab->config_get_data_table_name}");
            //         Log::info($th);
            //     }
            // }

            // #Local Log
            // DB::table('log_cronjob')
            // ->insert([
            //     'log_cronjob_name' => 'mastercontroll:cron',
            //     'log_cronjob_from_server_id' => $getSourceConn->db_con_m_w_id,
            //     'log_cronjob_from_server_name' => $getSourceConn->db_con_location_name,
            //     'log_cronjob_to_server_id' => $dest->db_con_m_w_id,
            //     'log_cronjob_to_server_name' => $dest->db_con_location_name,
            //     'log_cronjob_datetime' => Carbon::now(),
            //     'log_cronjob_note' => $valTab->config_get_data_table_name.'-CHECKED!',
            // ]);

            // #Cek Last Sync
            // $lastId = DB::table('log_data_sync')
            //             ->where('log_data_sync_cron','mastercontroll:cron')
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
            //                 'log_data_sync_cron' => 'mastercontroll:cron',
            //                 'log_data_sync_table' => $valTab->config_get_data_table_name,
            //             ],
            //             [
            //                 'log_data_sync_cron' => 'mastercontroll:cron',
            //                 'log_data_sync_table' => $valTab->config_get_data_table_name,
            //                 'log_data_sync_last' => $nextLast,
            //                 'log_data_sync_note' => 'ok'
            //             ]
            //         );
            //         #Local Log
            //         DB::table('log_cronjob')
            //         ->insert([
            //             'log_cronjob_name' => 'mastercontroll:cron',
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

        Log::info("Cronjob MASTER CONTROLL FINISH at ". Carbon::now()->format('Y-m-d H:i:s'));
        return Command::SUCCESS;
    }
}
