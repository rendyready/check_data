<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Schema;

class DataSyncCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'datasync:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cronjob for synchron data pusat-area-waroeng';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /**
         * Data Synchronous Service Waroeng <-> Pusat(Master) <-> Area
         * By Jangkrik500
         */

        info("Cron Job Data Transfer START at ". Carbon::now()->format('Y-m-d H:i:s'));
        #cek Status Cronjob
        $cronStatus = DB::table('cronjob')
                    ->where('cronjob_name','datasync:cron')
                    ->first();

        $startTime = Carbon::parse($cronStatus->cronjob_updated_at);
        $finishTime = Carbon::now();

        $totalDuration = $finishTime->diffInMinutes($startTime);

        if ($cronStatus->cronjob_status == 'close' && $totalDuration <= 10) {
            info("Cronjob canceled. Another Cronjob in process.");
            exit();
        }else{
            DB::table('cronjob')
                ->where('cronjob_name','datasync:cron')
                ->update([
                    'cronjob_status' => 'close',
                    'cronjob_updated_at' => Carbon::now()
                ]);
        }

        #Open Connection to source database
        $getSourceConn = DB::table('db_con')->where('db_con_data_status','source')
            ->where('db_con_sync_status','aktif')
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
            // $cekConn = DB::connection('source')->getDatabaseName();
            // $cekConn = Schema::connection('source')->getAllTables();
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
            // die("Could not connect to the database. Error:" . $e );
            info("Could not connect to the SOURCE database. Error:" . $e);
            DB::table('cronjob')
                ->where('cronjob_name','datasync:cron')
                ->update([
                    'cronjob_status' => 'open',
                    'cronjob_updated_at' => Carbon::now()
                ]);

            DB::table('db_con')->where('db_con_id',$getSourceConn->db_con_id)
            ->update([
                'db_con_network_status' => 'disconnect'
            ]);
            exit();
        }

        #Get List Table to Check data exist to send
        $getTableList = DB::table('config_sync')
                        ->where('config_sync_status','aktif')
                        ->get();
        $tableList = array();
        $tableListArea = array();
        foreach ($getTableList as $key => $val) {
            $statusCheck1 = "send";
            $statusCheck2 = "edit";
            if ($getSourceConn->db_con_location == "pusat" && $val->config_sync_table_tipe == "transaksi") {
                $statusCheck1 = "send-area";
                $statusCheck2 = "edit-area";
            }

            #Checking data where need to Send
            $cek = $DbSource->table($val->config_sync_table_name)
                    ->where($val->config_sync_field_status,"{$statusCheck1}")
                    ->orWhere($val->config_sync_field_status,"{$statusCheck2}")
                    ->orderBy($val->config_sync_field_validate1,'asc')
                    ->limit(1)
                    ->count();

            if ($cek > 0) {
                if ($statusCheck1 == "send" && $statusCheck2 == "edit") {
                    array_push($tableList,$val);
                } else {
                    array_push($tableListArea,$val);
                }
            }
        }

        if (count($tableList) == 0 && count($tableListArea) == 0) {
            info("No Data to transfer");
            exit();
        }

        #Transfer Data Pusat <-> Waroeng
        if (count($tableList) > 0) {
            #Get List Destination to Sync
            $dest = DB::table('db_con')->where('db_con_data_status','destination')
                    ->where('db_con_sync_status','aktif');
            $countDest = $dest->count();
            $getDest = $dest->get();

            $errorConnCounter = 0;
            $counterConn = 1;
            foreach ($getDest as $keyDest => $valDest) {
                #Setup Connection to Destination
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
                    // $cekConn = DB::connection($connName)->getDatabaseName();
                    $cekConn = Schema::connection('source')->hasTable('users');

                    $status = '';
                    if ($cekConn) {
                        $status = 'connect';
                        $DbDest = DB::connection($connName);
                        DB::table('db_con')->where('db_con_id',$valDest->db_con_id)
                        ->update([
                            'db_con_network_status' => $status
                        ]);
                    }

                } catch (\Exception $e) {
                    $errorConnCounter++;
                    // die("Could not connect to the database. Error:" . $e );
                    info("Could not connect to Destination {$valDest->db_con_location_name}. Error:" . $e);
                    DB::table('db_con')->where('db_con_id',$valDest->db_con_id)
                        ->update([
                            'db_con_network_status' => 'disconnect'
                        ]);
                    #skip executing on error connection
                    continue;
                }

                $errorTableCounter = 0;
                $countTable = 1;
                foreach ($tableList as $keyTab => $valTab) {
                    #get Schema Table From resource
                    $sourceSchema = Schema::connection('source')->getColumnListing($valTab->config_sync_table_name);
                    $destSchema = Schema::connection($connName)->getColumnListing($valTab->config_sync_table_name);
                    if (count($sourceSchema) != count($destSchema)) {
                        $errorTableCounter++;
                        info("DB structur of {$valDest->db_con_location_name} EXPIRED");
                        #SKIP
                        continue;
                    }

                    $statusCheck1 = "send";
                    $statusCheck2 = "edit";
                    $fieldStatus = $valTab->config_sync_field_status;
                    #Get data from source
                    $getDataSource = $DbSource->table($valTab->config_sync_table_name);
                    if ($valTab->config_sync_truncate == "tidak") {
                        $getDataSource->where($fieldStatus,"{$statusCheck1}");
                        $getDataSource->orWhere($fieldStatus,"{$statusCheck2}");
                        $getDataSource->orderBy($valTab->config_sync_field_validate1,'asc');
                        $getDataSource->limit($valTab->config_sync_limit);
                    }

                    if ($valTab->config_sync_truncate == "aktif" && $valTab->config_sync_table_tipe == "master") {
                        $DbDest->statement("TRUNCATE TABLE {$valTab->config_sync_table_name} RESTART IDENTITY;");
                    }

                    #PUSH data to Destination
                    foreach ($getDataSource->get() as $keyDataSource => $valDataSource) {

                        if ($valDataSource->$fieldStatus == "send" && $valTab->config_sync_table_tipe == "transaksi") {
                            $newDestStatus = "ok";
                            if ($getSourceConn->db_con_location == "waroeng") {
                                $newDestStatus = "send-area";
                            }

                            $data = [];
                            foreach ($sourceSchema as $keySchema => $valSchema) {
                                if ($valSchema != 'id') {
                                    if ($valSchema == $valTab->config_sync_field_status) {
                                        $data[$valSchema] = $newDestStatus;
                                    } else {
                                        $data[$valSchema] = $valDataSource->$valSchema;
                                    }
                                }
                            }

                            try {
                                $push = $DbDest->table($valTab->config_sync_table_name)
                                ->insert($data);
                                // return $push;
                                if ($push) {
                                    #update source data
                                    if ($errorConnCounter == 0 && $counterConn == $countDest) {
                                        $update = $DbSource->table($valTab->config_sync_table_name);
                                        for ($i=1; $i <= 4; $i++) {
                                            $validate = "config_sync_field_validate{$i}";
                                            $validateField = $valTab->$validate;
                                            if (!empty($validateField)) {
                                                $update->where($validateField,$valDataSource->$validateField);
                                            }
                                        }
                                        $update->update([
                                            $valTab->config_sync_field_status => "ok"
                                        ]);
                                    }
                                }
                            } catch (\Throwable $th) {
                                $cekReady = $DbDest->table($valTab->config_sync_table_name);
                                for ($i=1; $i <= 4; $i++) {
                                    $validate = "config_sync_field_validate{$i}";
                                    $validateField = $valTab->$validate;
                                    if (!empty($validateField)) {
                                        $valDataSource->$validateField;
                                        $cekReady->where($validateField,$valDataSource->$validateField);
                                    }
                                }
                                $push = $DbDest->table($valTab->config_sync_table_name);
                                if ($cekReady->count() > 0) {
                                    for ($i=1; $i <= 4; $i++) {
                                        $validate = "config_sync_field_validate{$i}";
                                        $validateField = $valTab->$validate;
                                        if (!empty($validateField)) {
                                            $push->where($validateField,$valDataSource->$validateField);
                                        }
                                    }
                                    $push->update($data);
                                    if ($push) {
                                        #update source data
                                        if ($errorConnCounter == 0 && $counterConn == $countDest) {
                                            $update = $DbSource->table($valTab->config_sync_table_name);
                                            for ($i=1; $i <= 4; $i++) {
                                                $validate = "config_sync_field_validate{$i}";
                                                $validateField = $valTab->$validate;
                                                if (!empty($validateField)) {
                                                    $update->where($validateField,$valDataSource->$validateField);
                                                }
                                            }
                                            $update->update([
                                                $valTab->config_sync_field_status => "ok"
                                            ]);
                                        }
                                    }
                                } else {
                                    info("Can't insert to {$valDest->db_con_location_name}-{$valTab->config_sync_table_name}");
                                    info("Error:" . $th);
                                    continue;
                                }
                            }
                        }else{
                            $newDestStatus = "ok";
                            if ($getSourceConn->db_con_location == "waroeng") {
                                $newDestStatus = "edit-area";
                            }
                            $data = [];
                            foreach ($sourceSchema as $keySchema => $valSchema) {
                                if ($valSchema != "id") {
                                    if ($valSchema == $valTab->config_sync_field_status) {
                                        $data[$valSchema] = $newDestStatus;
                                    } else {
                                        $data[$valSchema] = $valDataSource->$valSchema;
                                    }
                                }
                            }
                            $cekReady = $DbDest->table($valTab->config_sync_table_name);
                            for ($i=1; $i <= 4; $i++) {
                                $validate = "config_sync_field_validate{$i}";
                                $validateField = $valTab->$validate;
                                if (!empty($validateField)) {
                                    $valDataSource->$validateField;
                                    $cekReady->where($validateField,$valDataSource->$validateField);
                                }
                            }

                            try {
                                $push = $DbDest->table($valTab->config_sync_table_name);
                                if ($cekReady->count() > 0) {
                                    for ($i=1; $i <= 4; $i++) {
                                        $validate = "config_sync_field_validate{$i}";
                                        $validateField = $valTab->$validate;
                                        if (!empty($validateField)) {
                                            $push->where($validateField,$valDataSource->$validateField);
                                        }
                                    }
                                    $push->update($data);
                                } else {
                                    $push->insert($data);
                                }

                                if ($push) {
                                    #update source data
                                    if ($errorConnCounter == 0 && $counterConn == $countDest) {
                                        $update = $DbSource->table($valTab->config_sync_table_name);
                                        for ($i=1; $i <= 4; $i++) {
                                            $validate = "config_sync_field_validate{$i}";
                                            $validateField = $valTab->$validate;
                                            if (!empty($validateField)) {
                                                $update->where($validateField,$valDataSource->$validateField);
                                            }
                                        }
                                        $update->update([
                                            $valTab->config_sync_field_status => "ok"
                                        ]);
                                    }
                                }
                            } catch (\Throwable $th) {
                                info("Can't update to {$valDest->db_con_location_name}-{$valTab->config_sync_table_name}");
                                info("Error:" . $th);
                                continue;
                            }

                        }
                    }
                    $countTable++;
                    if (count($tableList) == $countTable) {
                        try {
                            #Logging to target
                            $DbDest->table('log_cronjob')
                            ->insert([
                                'log_cronjob_name' => 'datasync:cron',
                                'log_cronjob_from_server_id' => $getSourceConn->db_con_m_w_id,
                                'log_cronjob_from_server_name' => $getSourceConn->db_con_location_name,
                                'log_cronjob_datetime' => Carbon::now()
                            ]);

                            #Local Log
                            $DbDest->table('log_cronjob')
                            ->insert([
                                'log_cronjob_name' => 'datasync:cron',
                                'log_cronjob_from_server_id' => $getSourceConn->db_con_m_w_id,
                                'log_cronjob_from_server_name' => $getSourceConn->db_con_location_name,
                                'log_cronjob_to_server_id' => $valDest->db_con_m_w_id,
                                'log_cronjob_to_server_name' => $valDest->db_con_location_name,
                                'log_cronjob_datetime' => Carbon::now(),
                                'log_cronjob_note' => 'Sukses!',
                            ]);
                        } catch (\Throwable $th) {
                            info("can't insert Log");

                        }
                    }
                }
                $counterConn++;
            }
        }

        #Transfer Data Pusat -> Area
        if ($tableListArea > 0) {
            #Get List Destination to Sync
            $dest = DB::table('db_con')->where('db_con_data_status','destination')
                    ->where('db_con_sync_status','aktif')
                    ->where('db_con_location','area');
            $countDest = $dest->count();
            $getDest = $dest->get();

            $errorConnCounter = 0;
            $counterConn = 1;
            foreach ($getDest as $keyDest => $valDest) {
                #Setup Connection to Destination
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
                    // $cekConn = DB::connection($connName)->getDatabaseName();
                    $cekConn = Schema::connection('source')->hasTable('users');

                    $status = '';
                    if ($cekConn) {
                        $status = 'connect';
                        $DbDest = DB::connection($connName);
                        DB::table('db_con')->where('db_con_id',$valDest->db_con_id)
                        ->update([
                            'db_con_network_status' => $status
                        ]);
                    }

                } catch (\Exception $e) {
                    $errorConnCounter++;
                    // die("Could not connect to the database. Error:" . $e );
                    info("Could not connect to Destination {$valDest->db_con_location_name}. Error:" . $e);
                    DB::table('db_con')->where('db_con_id',$valDest->db_con_id)
                        ->update([
                            'db_con_network_status' => 'disconnect'
                        ]);
                    #skip executing on error connection
                    continue;
                }

                $errorTableCounter = 0;
                $countTable = 1;
                foreach ($tableListArea as $keyTab => $valTab) {
                    #get Schema Table From resource
                    $sourceSchema = Schema::connection('source')->getColumnListing($valTab->config_sync_table_name);
                    $destSchema = Schema::connection($connName)->getColumnListing($valTab->config_sync_table_name);
                    if (count($sourceSchema) != count($destSchema)) {
                        $errorTableCounter++;
                        info("DB structur of {$valDest->db_con_location_name} is EXPIRED");
                        #SKIP
                        continue;
                    }

                    $statusCheck1 = "send-area";
                    $statusCheck2 = "edit-area";
                    $fieldStatus = $valTab->config_sync_field_status;
                    #Get data from source
                    $getDataSource = $DbSource->table($valTab->config_sync_table_name);
                    if ($valTab->config_sync_truncate == "tidak") {
                        $getDataSource->where($fieldStatus,"{$statusCheck1}");
                        $getDataSource->orWhere($fieldStatus,"{$statusCheck2}");
                        $getDataSource->orderBy($valTab->config_sync_field_validate1,'asc');
                        $getDataSource->limit($valTab->config_sync_limit);
                    }

                    if ($valTab->config_sync_truncate == "aktif" && $valTab->config_sync_table_tipe == "master") {
                        $DbDest->statement("TRUNCATE TABLE {$valTab->config_sync_table_name} RESTART IDENTITY;");
                    }

                    #PUSH data to Destination
                    foreach ($getDataSource->get() as $keyDataSource => $valDataSource) {

                        if ($valDataSource->$fieldStatus == "send-area" && $valTab->config_sync_table_tipe == "transaksi") {
                            $newDestStatus = "ok";
                            // if ($getSourceConn->db_con_location == "waroeng") {
                            //     $newDestStatus = "send-area";
                            // }

                            $data = [];
                            foreach ($sourceSchema as $keySchema => $valSchema) {
                                if ($valSchema != 'id') {
                                    if ($valSchema == $valTab->config_sync_field_status) {
                                        $data[$valSchema] = $newDestStatus;
                                    } else {
                                        $data[$valSchema] = $valDataSource->$valSchema;
                                    }
                                }
                            }

                            try {
                                $push = $DbDest->table($valTab->config_sync_table_name)
                                ->insert($data);
                                // return $push;
                                if ($push) {
                                    #update source data
                                    if ($errorConnCounter == 0 && $counterConn == $countDest) {
                                        $update = $DbSource->table($valTab->config_sync_table_name);
                                        for ($i=1; $i <= 4; $i++) {
                                            $validate = "config_sync_field_validate{$i}";
                                            $validateField = $valTab->$validate;
                                            if (!empty($validateField)) {
                                                $update->where($validateField,$valDataSource->$validateField);
                                            }
                                        }
                                        $update->update([
                                            $valTab->config_sync_field_status => "ok"
                                        ]);
                                    }
                                }
                            } catch (\Throwable $th) {
                                $cekReady = $DbDest->table($valTab->config_sync_table_name);
                                for ($i=1; $i <= 4; $i++) {
                                    $validate = "config_sync_field_validate{$i}";
                                    $validateField = $valTab->$validate;
                                    if (!empty($validateField)) {
                                        $valDataSource->$validateField;
                                        $cekReady->where($validateField,$valDataSource->$validateField);
                                    }
                                }
                                $push = $DbDest->table($valTab->config_sync_table_name);
                                if ($cekReady->count() > 0) {
                                    for ($i=1; $i <= 4; $i++) {
                                        $validate = "config_sync_field_validate{$i}";
                                        $validateField = $valTab->$validate;
                                        if (!empty($validateField)) {
                                            $push->where($validateField,$valDataSource->$validateField);
                                        }
                                    }
                                    $push->update($data);
                                    if ($push) {
                                        #update source data
                                        if ($errorConnCounter == 0 && $counterConn == $countDest) {
                                            $update = $DbSource->table($valTab->config_sync_table_name);
                                            for ($i=1; $i <= 4; $i++) {
                                                $validate = "config_sync_field_validate{$i}";
                                                $validateField = $valTab->$validate;
                                                if (!empty($validateField)) {
                                                    $update->where($validateField,$valDataSource->$validateField);
                                                }
                                            }
                                            $update->update([
                                                $valTab->config_sync_field_status => "ok"
                                            ]);
                                        }
                                    }
                                } else {
                                    info("Can't insert to {$valDest->db_con_location_name}-{$valTab->config_sync_table_name}");
                                    info("Error:" . $th);
                                    continue;
                                }
                            }
                        }else{
                            $newDestStatus = "ok";
                            // if ($getSourceConn->db_con_location == "waroeng") {
                            //     $newDestStatus = "edit-area";
                            // }
                            $data = [];
                            foreach ($sourceSchema as $keySchema => $valSchema) {
                                if ($valSchema != "id") {
                                    if ($valSchema == $valTab->config_sync_field_status) {
                                        $data[$valSchema] = $newDestStatus;
                                    } else {
                                        $data[$valSchema] = $valDataSource->$valSchema;
                                    }
                                }
                            }
                            $cekReady = $DbDest->table($valTab->config_sync_table_name);
                            for ($i=1; $i <= 4; $i++) {
                                $validate = "config_sync_field_validate{$i}";
                                $validateField = $valTab->$validate;
                                if (!empty($validateField)) {
                                    $valDataSource->$validateField;
                                    $cekReady->where($validateField,$valDataSource->$validateField);
                                }
                            }

                            try {
                                $push = $DbDest->table($valTab->config_sync_table_name);
                                if ($cekReady->count() > 0) {
                                    for ($i=1; $i <= 4; $i++) {
                                        $validate = "config_sync_field_validate{$i}";
                                        $validateField = $valTab->$validate;
                                        if (!empty($validateField)) {
                                            $push->where($validateField,$valDataSource->$validateField);
                                        }
                                    }
                                    $push->update($data);
                                } else {
                                    $push->insert($data);
                                }

                                if ($push) {
                                    #update source data
                                    if ($errorConnCounter == 0 && $counterConn == $countDest) {
                                        $update = $DbSource->table($valTab->config_sync_table_name);
                                        for ($i=1; $i <= 4; $i++) {
                                            $validate = "config_sync_field_validate{$i}";
                                            $validateField = $valTab->$validate;
                                            if (!empty($validateField)) {
                                                $update->where($validateField,$valDataSource->$validateField);
                                            }
                                        }
                                        $update->update([
                                            $valTab->config_sync_field_status => "ok"
                                        ]);
                                    }
                                }
                            } catch (\Throwable $th) {
                                info("Can't update to {$valDest->db_con_location_name}-{$valTab->config_sync_table_name}");
                                info("Error:" . $th);
                                continue;
                            }

                        }
                    }
                    $countTable++;
                    if (count($tableList) == $countTable) {
                        try {
                            #Logging to target
                            $DbDest->table('log_cronjob')
                            ->insert([
                                'log_cronjob_name' => 'datasync:cron',
                                'log_cronjob_from_server_id' => $getSourceConn->db_con_m_w_id,
                                'log_cronjob_from_server_name' => $getSourceConn->db_con_location_name,
                                'log_cronjob_datetime' => Carbon::now()
                            ]);

                            #Local Log
                            $DbDest->table('log_cronjob')
                            ->insert([
                                'log_cronjob_name' => 'datasync:cron',
                                'log_cronjob_from_server_id' => $getSourceConn->db_con_m_w_id,
                                'log_cronjob_from_server_name' => $getSourceConn->db_con_location_name,
                                'log_cronjob_to_server_id' => $valDest->db_con_m_w_id,
                                'log_cronjob_to_server_name' => $valDest->db_con_location_name,
                                'log_cronjob_datetime' => Carbon::now(),
                                'log_cronjob_note' => 'Sukses!',
                            ]);
                        } catch (\Throwable $th) {
                            info("can't insert Log");
                        }

                    }
                }
                $counterConn++;
            }
        }
        info("Cron Job Data Transfer FINISH at ". Carbon::now()->format('Y-m-d H:i:s'));

        DB::table('cronjob')
        ->where('cronjob_name','datasync:cron')
        ->update([
            'cronjob_status' => 'open',
            'cronjob_updated_at' => Carbon::now()
        ]);
        return Command::SUCCESS;
    }
}
