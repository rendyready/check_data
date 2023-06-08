<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class GetDataUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getdataupdate:cron';

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
                    ->where('cronjob_name','getdataupdate:cron')
                    ->first();

        if ($cronStatus->cronjob_status == 'open') {
            info("Cronjob GET Data START at ". Carbon::now()->format('Y-m-d H:i:s'));
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
                $DbSource = DB::connection('source');

                DB::table('db_con')->where('db_con_id',$getSourceConn->db_con_id)
                    ->update([
                        'db_con_network_status' => $status
                    ]);
            }

        } catch (\Exception $e) {
            info("Could not connect to the SOURCE database. Error:" . $e);
            DB::table('db_con')->where('db_con_id',$getSourceConn->db_con_id)
            ->update([
                'db_con_network_status' => 'disconnect'
            ]);
            exit();
        }

        #GET Data is open?
        $getDataOpen = $DbSource->table('cronjob')
            ->where('cronjob_name','getdataupdate:cron')
            ->first();

        if ($getDataOpen->cronjob_status == 'close') {
            Log::alert("GET DATA NOT ALLOWED. SERVER BUSY.");
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
                $DbDest = DB::connection('destination');
                DB::table('db_con')->where('db_con_id',$dest->db_con_id)
                ->update([
                    'db_con_network_status' => $status
                ]);
            }

        } catch (\Exception $e) {
            info("Could not connect to Destination. Error:" . $e);
            DB::table('db_con')->where('db_con_id',$dest->db_con_id)
                ->update([
                    'db_con_network_status' => 'disconnect'
                ]);
            #skip executing on error connection
            exit();
        }

        $getTableList = DB::table('config_get_data')
                        ->where('config_get_data_status','on')
                        ->orderBy('config_get_data_id','asc')
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

            // $except = array('app_setting','role_has_permissions','model_has_permissions','model_has_roles');
            // if (!in_array($valTab->config_get_data_table_name,$except)) {
            if ($valTab->config_get_data_sequence == 'on') {
                #Get Last Increment Used
                $maxId = $DbDest->select("SELECT MAX(id) FROM {$valTab->config_get_data_table_name};")[0]->max;

                #GET Current Increment of table (Recomended method)
                $currentId = $DbDest->select("SELECT last_value FROM {$valTab->config_get_data_table_name}_id_seq;")[0]->last_value;
                if (empty($maxId)) {
                    if ($currentId > 1) {
                        $DbDest->select("SELECT setval('{$valTab->config_get_data_table_name}_id_seq', 1);");
                    }
                }else{
                    if ($maxId != $currentId) {
                        $DbDest->select("SELECT setval('{$valTab->config_get_data_table_name}_id_seq', {$maxId});");
                    }
                }
            }

            #Cek Last Sync
            $lastId = DB::table('log_data_sync')
                        ->where('log_data_sync_cron','getdataupdate:cron')
                        ->where('log_data_sync_table',$valTab->config_get_data_table_name)
                        ->first();

            $statusCheck1 = "send";
            $statusCheck2 = "edit";
            $fieldStatus = $valTab->config_get_data_field_status;
            $getDataSource = $DbSource->table($valTab->config_get_data_table_name);
            if (!empty($lastId)) {
                $getDataSource->where($valTab->config_get_data_field_validate1,'>',$lastId->log_data_sync_last);
            }
            if ($valTab->config_get_data_truncate == "off") {
                $getDataSource->where($fieldStatus,"{$statusCheck1}");
                $getDataSource->orWhere($fieldStatus,"{$statusCheck2}");
                $getDataSource->orderBy($valTab->config_get_data_field_validate1,'asc');
                if ($valTab->config_get_data_limit > 0) {
                    $getDataSource->limit($valTab->config_get_data_limit);
                }
            }

            if ($valTab->config_get_data_truncate == "on" && $valTab->config_get_data_table_tipe == "master") {
                $DbDest->statement("TRUNCATE TABLE {$valTab->config_get_data_table_name} RESTART IDENTITY;");
            }

            #PUSH data to Destination
            $nextLast = 0;
            if ($getDataSource->get()->count() > 0) {
                foreach ($getDataSource->get() as $keyDataSource => $valDataSource) {
                    $newDestStatus = "ok";
                    $data = [];
                    foreach ($sourceSchema as $keySchema => $valSchema) {
                        if ($valSchema != 'id') {
                            if ($valSchema == $valTab->config_get_data_field_status) {
                                $data[$valSchema] = $newDestStatus;
                            } else {
                                $data[$valSchema] = $valDataSource->$valSchema;
                            }
                        }
                    }
                    try {
                        // $validateField = $valTab->config_get_data_field_validate1;
                        $validationField = [];
                        for ($i=1; $i <= 4; $i++) {
                            $validate = "config_get_data_field_validate{$i}";
                            $validateField = $valTab->$validate;
                            if (!empty($validateField)) {
                                $validationField[$validateField] = $valDataSource->$validateField;
                            }
                        }
                        $DbDest->table($valTab->config_get_data_table_name)
                            ->updateOrInsert(
                                $validationField,
                                $data
                            );

                        $validateField1 = $valTab->config_get_data_field_validate1;
                        $nextLast = $valDataSource->$validateField1;

                    } catch (\Throwable $th) {
                        Log::alert("Can't insert/update to {$valTab->config_get_data_table_name}");
                        Log::info($th);
                    }
                }
            }
            if ($nextLast == 0) {
                $validateField = $valTab->config_get_data_field_validate1;
                $nextLast = $DbSource->table($valTab->config_get_data_table_name)
                    ->orderBy($valTab->config_get_data_field_validate1,'asc')
                    ->first()->$validateField;
            }
            if ($nextLast != 0) {
                DB::table('log_data_sync')
                    ->updateOrInsert(
                    [
                        'log_data_sync_cron' => 'getdataupdate:cron',
                        'log_data_sync_table' => $valTab->config_get_data_table_name,
                    ],
                    [
                        'log_data_sync_cron' => 'getdataupdate:cron',
                        'log_data_sync_table' => $valTab->config_get_data_table_name,
                        'log_data_sync_last' => $nextLast,
                        'log_data_sync_note' => 'ok'
                    ]
                );
                #Local Log
                DB::table('log_cronjob')
                ->insert([
                    'log_cronjob_name' => 'getdataupdate:cron',
                    'log_cronjob_from_server_id' => $getSourceConn->db_con_m_w_id,
                    'log_cronjob_from_server_name' => $getSourceConn->db_con_location_name,
                    'log_cronjob_to_server_id' => $dest->db_con_m_w_id,
                    'log_cronjob_to_server_name' => $dest->db_con_location_name,
                    'log_cronjob_datetime' => Carbon::now(),
                    'log_cronjob_note' => $valTab->config_get_data_table_name.'-UPDATED!',
                ]);
            }
        }

        Log::info("Cronjob GET Data FINISH at ". Carbon::now()->format('Y-m-d H:i:s'));

        return Command::SUCCESS;
    }
}
