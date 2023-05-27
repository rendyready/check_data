<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use App\Helpers\Helper;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;



class CronjobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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

        return "Done!";
    }

    public function migrate(string $dbcon = '')
    {
        try {
            Artisan::call('migrate', array(
                '--database' => $dbcon,
                '--path' => 'database/migrations',
                '--force' => true,
            ));
            return "succes";

        } catch (\Throwable $th) {
            return "gagal";
        }

    }

    public function encrypt($pass)
    {
        return response(Helper::customCrypt($pass));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function Coba()
    {
        $clientConnection = DB::table('db_connection')->get(); //get data client

        foreach ($clientConnection as $key => $value) {
            Config::set("database.connections.{$value->db_connection_client_code}", [
                'driver' => 'pgsql',
                'host' => $value->db_connection_host,
                'port' => $value->db_connection_port,
                'database' => $value->db_connection_dbname,
                'username' => $value->db_connection_username,
                'password' => Helper::customDecrypt($value->db_connection_password),
                'charset' => 'utf8',
                'prefix' => '',
                'prefix_indexes' => true,
                'search_path' => 'public',
                'sslmode' => 'prefer',
             ]);
        }

        //Update Status Connection #jangkrik404
        foreach ($clientConnection as $key => $value) {
            try {
                $clientTest = DB::connection($value->db_connection_client_code)->getDatabaseName();
                $clientStatus = '';
                if (!empty($clientTest)) {
                    $clientStatus = 'Connect';
                }else {
                    $clientStatus = 'Disconnect';
                }
            } catch (\Throwable $th) {
                $clientStatus = 'Error Access';
            }

            DB::table('db_connection')
                ->where('db_connection_id', $value->db_connection_id)
                ->update([
                    'db_connection_status' => $clientStatus
                ]);
        }

        //Schema Database Synchron #Jangkrik404
        // Step 1 : Get Structur DB Server
        $serverTable = Schema::getAllTables();
        $serverSchema = [];
        $t=1;
        foreach ($serverTable as $keyT => $valT) {
            // $serverSchema[$t] = $valT->tablename;

            $serverFields = Schema::getColumnListing($valT->tablename);
            $f=1;
            foreach ($serverFields as $keyF => $valF) {
                $serverFieldType = Schema::getColumnType($valT->tablename,$valF);
                $serverSchema[$t][$valT->tablename][$f]['fieldName'] = $valF;
                $serverSchema[$t][$valT->tablename][$f]['fieldType'] = $serverFieldType;
                $f++;
            }

            $t++;
        }

        foreach ($clientConnection as $key => $value) {

        }
        dd($serverSchema);
        // return $db = Schema::connection('1')->getColumnListing('users');
        // return Schema::connection('1')->getColumnType('users','email');

        // var_dump($clientConnection);
    }

    public function getdata()
    {
        // $count = 70127;
        // $bagi = ($count/100)/70;
        // echo $bagi."<br>";
        // return ceil($bagi);
        #Cek cronjob status
        $cronStatus = DB::table('cronjob')
                    ->where('cronjob_name','getdata:cron')
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
            ->where('cronjob_name','getdata:cron')
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
            $cekConn = Schema::connection('source')->hasTable('users');

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

            if ($valTab->config_get_data_truncate == "on" && $valTab->config_get_data_table_tipe == "master") {
                $DbDest->statement("TRUNCATE TABLE {$valTab->config_get_data_table_name} RESTART IDENTITY;");
            }

            #First check to setup looping
            $ready = $DbDest->table($valTab->config_get_data_table_name)->get();
            $fieldId = $valTab->config_get_data_field_validate1;
            $filterNotIn = [];
            foreach ($ready as $key => $value) {
                array_push($filterNotIn,$value->$fieldId);
            }

            $statusCheck1 = "send";
            $statusCheck2 = "edit";
            $fieldStatus = $valTab->config_get_data_field_status;
            $getDataSource = $DbSource->table($valTab->config_get_data_table_name);
            if ($valTab->config_get_data_truncate == "off") {
                $getDataSource->whereNotIn($valTab->config_get_data_field_validate1,$filterNotIn);
                $getDataSource->orWhere($fieldStatus,"{$statusCheck1}");
                $getDataSource->orWhere($fieldStatus,"{$statusCheck2}");
                $getDataSource->orderBy($valTab->config_get_data_field_validate1,'asc');
            }

            $countData = $getDataSource->count();
            $bagi = ($valTab->config_get_data_limit == 0) ? 1:$valTab->config_get_data_limit;
            $loop = ceil($countData/$bagi);

            if ($loop > 0) {
                if ($loop > 10) {
                    $loop = 10;
                }
                for ($i=1; $i <= $loop; $i++) {
                    #filter data ready on lokal
                    $ready = $DbDest->table($valTab->config_get_data_table_name)->get();
                    $fieldId = $valTab->config_get_data_field_validate1;
                    $filterNotIn = [];
                    foreach ($ready as $key => $value) {
                        array_push($filterNotIn,$value->$fieldId);
                    }

                    $statusCheck1 = "send";
                    $statusCheck2 = "edit";
                    $fieldStatus = $valTab->config_get_data_field_status;
                    $getDataSource = $DbSource->table($valTab->config_get_data_table_name);
                    if ($valTab->config_get_data_truncate == "off") {
                        $getDataSource->whereNotIn($valTab->config_get_data_field_validate1,$filterNotIn);
                        $getDataSource->orWhere($fieldStatus,"{$statusCheck1}");
                        $getDataSource->orWhere($fieldStatus,"{$statusCheck2}");
                        $getDataSource->orderBy($valTab->config_get_data_field_validate1,'asc');
                        if ($valTab->config_get_data_limit > 0) {
                            $getDataSource->limit($valTab->config_get_data_limit);
                        }
                    }

                    #PUSH data to Destination
                    if ($getDataSource->count() > 0) {
                        // if ($valTab->config_get_data_table_name == 'm_menu_harga') {
                        //     return $getDataSource->get();
                        // }
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
                                $validateField = $valTab->config_get_data_field_validate1;
                                $DbDest->table($valTab->config_get_data_table_name)
                                    ->updateOrInsert(
                                        [
                                            $valTab->config_get_data_field_validate1 => $valDataSource->$validateField
                                        ],
                                        $data
                                    );
                            } catch (\Throwable $th) {
                                Log::alert("Can't insert/update to {$valTab->config_get_data_table_name}");
                                Log::info($th);
                            }
                        }
                    }
                }
                #Local Log
                DB::table('log_cronjob')
                ->insert([
                    'log_cronjob_name' => 'getdata:cron',
                    'log_cronjob_from_server_id' => $getSourceConn->db_con_m_w_id,
                    'log_cronjob_from_server_name' => $getSourceConn->db_con_location_name,
                    'log_cronjob_to_server_id' => $dest->db_con_m_w_id,
                    'log_cronjob_to_server_name' => $dest->db_con_location_name,
                    'log_cronjob_datetime' => Carbon::now(),
                    'log_cronjob_note' => $valTab->config_get_data_table_name.'-Updated!',
                ]);
            }
        }

        Log::info("Cronjob GET Data FINISH at ". Carbon::now()->format('Y-m-d H:i:s'));

        return "ok";
    }

    public function sendcloud()
    {
        #Cek cronjob status
        $cronStatus = DB::table('cronjob')
                    ->where('cronjob_name','sendcloud:cron')
                    ->first();

        if (!empty($cronStatus)) {
            if ($cronStatus->cronjob_status == 'open') {
                info("Cronjob SEND CLOUD START at ". Carbon::now()->format('Y-m-d H:i:s'));
            }
        }else{
            return Command::SUCCESS;
        }

        #get source
        $getSourceConn = DB::table('db_con')
            ->where('db_con_data_status','source')
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

        #GET Destination Cloud
        // Config::set("database.connections.destination", [
        //     'driver' => 'pgsql',
        //     'host' => 'dbwss.waroengss.com',
        //     'port' => '5432',
        //     'database' => 'admindb_penjualan_wss',
        //     'username' => 'admindb_penjualan55',
        //     'password' => 'Sales@55wss',
        //     'charset' => 'utf8',
        //     'prefix' => '',
        //     'prefix_indexes' => true,
        //     'search_path' => 'public',
        //     'sslmode' => 'prefer',
        // ]);

        #Local Test
        Config::set("database.connections.destination", [
            'driver' => 'pgsql',
            'host' => '127.0.0.1',
            'port' => '5432',
            'database' => 'penjualan_wss',
            'username' => 'ihsanmac',
            'password' => 'jangkrik404',
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
                $DbDest = DB::connection('destination');
            }
        } catch (\Exception $e) {
            info("Could not connect to Server Cloud. Error:" . $e);
            #skip executing on error connection
            exit();
        }

        #Cek Last Sync
        $lastSync = DB::table('log_sendcloud')
        ->where('log_sendcloud_table','rekap_transaksi')
        ->first();

        #Send Transaksi Tabel
        $transaksiSchema = Schema::connection('source')->getColumnListing('rekap_transaksi');
        $getTransaksi = $DbSource->table('rekap_transaksi');
            if (!empty($lastSync)) {
                $lastId = (INT)$lastSync->log_sendcloud_last_id;
                $getTransaksi->where('id','>',$lastId);
            }
            $getTransaksi->orderBy('id','asc');
            $getTransaksi->limit(100);

        #PUSH data to Destination
        if (!empty($getTransaksi->get())) {
            $lastId = 0;
            foreach ($getTransaksi->get() as $keyDataSource => $valDataTrans) {
                /**
                 * Cek Collection Status
                 * 0 = 0 % -> 100 %
                 * 1 = 100 % -> 0 %
                 * 2 = 50 % -> 50 %
                 * 3 = 33 % -> 67 %
                 * 4 = 25 % -> 75 %
                 * 5 = 20 % <-> 80 %
                 * 10 = 10 % <-> 90 %
                */
                $collectStatus = $DbSource->table('m_w')
                    ->where('m_w_id',$valDataTrans->r_t_m_w_id)
                    ->first()->m_w_collect_status;

                $act = 1;
                if ($collectStatus == 1) {
                    $act = 0;
                }

                $rowKey = explode(".",$valDataTrans->r_t_id);
                $rowNumber = (count($rowKey) == 6) ? $rowKey[5] : 0;

                if ($collectStatus > 1 && $rowNumber > 0) {
                    $cek = fmod($rowNumber, $collectStatus);
                    if ($cek == 0) {
                        $act = 0;
                    }
                }

                if ($act == 0) {
                    continue;
                }

                $newDestStatus = "ok";
                $data = [];
                foreach ($transaksiSchema as $keySchema => $valSchema) {
                    if ($valSchema != 'id') {
                        if ($valSchema == 'r_t_status_sync') {
                            $data[$valSchema] = $newDestStatus;
                        } else {
                            $data[$valSchema] = $valDataTrans->$valSchema;
                        }
                    }
                }

                try {
                    $DbDest->table('rekap_transaksi')
                        ->updateOrInsert(
                            [
                                'r_t_id' => $valDataTrans->r_t_id
                            ],
                            $data
                        );
                } catch (\Throwable $th) {
                    Log::alert("Can't insert/update to Rekap Transaksi");
                    Log::info($th);
                }

                #PUSH Transaksi Detail Tabel
                $transDetSchema = Schema::connection('source')->getColumnListing('rekap_transaksi_detail');
                $getTransDet = $DbSource->table('rekap_transaksi_detail')
                    ->where('r_t_detail_r_t_id',$valDataTrans->r_t_id)
                    ->orderBy('id','asc')
                    ->limit(200);

                if ($getTransDet->count() > 0) {
                    foreach ($getTransDet->get() as $keyTransDet => $valTransDet) {
                        $newDestStatus = "ok";
                        $data = [];
                        foreach ($transDetSchema as $keyTransDetSchema => $valTransDetSchema) {
                            if ($valTransDetSchema != 'id') {
                                if ($valTransDetSchema == 'r_t_detail_status_sync') {
                                    $data[$valTransDetSchema] = $newDestStatus;
                                } else {
                                    $data[$valTransDetSchema] = $valTransDet->$valTransDetSchema;
                                }
                            }
                        }
                        try {
                            $DbDest->table('rekap_transaksi_detail')
                                ->updateOrInsert(
                                    [
                                        'r_t_detail_id' => $valTransDet->r_t_detail_id
                                    ],
                                    $data
                                );
                        } catch (\Throwable $th) {
                            Log::alert("Can't insert/update to Rekap Transaksi Detail");
                            Log::info($th);
                        }
                    }
                }

                #PUSH Refund Tabel
                $refundSchema = Schema::connection('source')->getColumnListing('rekap_refund');
                $getRefund = $DbSource->table('rekap_refund')
                    ->where('r_r_r_t_id',$valDataTrans->r_t_id)
                    ->orderBy('id','asc')
                    ->limit(200);

                if ($getRefund->count() > 0) {
                    foreach ($getRefund->get() as $keyRefund => $valRefund) {
                        $newDestStatus = "ok";
                        $data = [];
                        foreach ($refundSchema as $keyrefundSchema => $valrefundSchema) {
                            if ($valrefundSchema != 'id') {
                                if ($valrefundSchema == 'r_r_status_sync') {
                                    $data[$valrefundSchema] = $newDestStatus;
                                } else {
                                    $data[$valrefundSchema] = $valRefund->$valrefundSchema;
                                }
                            }
                        }
                        try {
                            $DbDest->table('rekap_refund')
                                ->updateOrInsert(
                                    [
                                        'r_r_id' => $valRefund->r_r_id
                                    ],
                                    $data
                                );
                        } catch (\Throwable $th) {
                            Log::alert("Can't insert/update to Rekap Refund");
                            Log::info($th);
                        }
                    }
                }

                #PUSH Refund Tabel
                $refundDetSchema = Schema::connection('source')->getColumnListing('rekap_refund_detail');
                $getRefundDet = $DbSource->table('rekap_refund_detail')
                    ->leftJoin('rekap_refund','r_r_id','r_r_detail_r_r_id')
                    ->leftJoin('rekap_transaksi','r_t_id','r_r_r_t_id')
                    ->where('r_r_r_t_id',$valDataTrans->r_t_id)
                    ->orderBy('id','asc')
                    ->limit(200);

                if ($getRefundDet->count() > 0) {
                    foreach ($getRefundDet->get() as $keyRefundDet => $valRefundDet) {
                        $newDestStatus = "ok";
                        $data = [];
                        foreach ($refundDetSchema as $keyrefundDetSchema => $valrefundDetSchema) {
                            if ($valrefundDetSchema != 'id') {
                                if ($valrefundDetSchema == 'r_r_status_sync') {
                                    $data[$valrefundDetSchema] = $newDestStatus;
                                } else {
                                    $data[$valrefundDetSchema] = $valRefundDet->$valrefundDetSchema;
                                }
                            }
                        }
                        try {
                            $DbDest->table('rekap_refund_detail')
                                ->updateOrInsert(
                                    [
                                        'r_r_detail_id' => $valRefundDet->r_r_detail_id
                                    ],
                                    $data
                                );
                        } catch (\Throwable $th) {
                            Log::alert("Can't insert/update to Rekap Refund Detail");
                            Log::info($th);
                        }
                    }
                }


                $lastId = $valDataTrans->id;
            }

            DB::table('log_sendcloud')
            ->updateOrInsert(
                [
                    'log_sendcloud_table' => 'rekap_transaksi'
                ],
                [
                    'log_sendcloud_table' => 'rekap_transaksi',
                    'log_sendcloud_last_id' => $lastId,
                    'log_sendcloud_note' => 'ok'
                ]
            );
        }

        #Local Log
        DB::table('log_cronjob')
        ->insert([
            'log_cronjob_name' => 'sendcloud:cron',
            'log_cronjob_from_server_id' => $getSourceConn->db_con_m_w_id,
            'log_cronjob_from_server_name' => $getSourceConn->db_con_location_name,
            'log_cronjob_to_server_id' => '01',
            'log_cronjob_to_server_name' => 'CLOUD',
            'log_cronjob_datetime' => Carbon::now(),
            'log_cronjob_note' => 'OK',
        ]);

        Log::info("Cronjob SEND CLOUD FINISH at ". Carbon::now()->format('Y-m-d H:i:s'));

        return "done!";
    }
}
