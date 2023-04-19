<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use App\Helpers\Helper;



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
         * Data Synchronous Service Waroeng <-> Pusat <-> Area(Master)
         * By Jangkrik500
         */
        info("Cron Job Data Transfer running at ". now());
        #Open Connection to source database
        $getSourceConn = DB::table('db_con')->where('db_con_data_status','source')->first();

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
            $cekConn = DB::connection('source')->getDatabaseName();

            $status = '';
            if (!empty($cekConn)) {
                $status = 'connect';
                $DbSource = DB::connection('source');
            }else {
                $status = 'disconnect';
            }
            DB::table('db_con')->where('db_con_id',$getSourceConn->db_con_id)
            ->update([
                'db_con_network_status' => $status
            ]);
        } catch (\Exception $e) {
            // die("Could not connect to the database. Error:" . $e );
            info("Could not connect to the SOURCE database. Error:" . $e);
            exit();
        }

        #Get List Table to Check data exist to send
        $getTableList = DB::table('config_sync')->get();
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
                    ->where($val->config_sync_field_status,$statusCheck1)
                    ->orWhere($val->config_sync_field_status,$statusCheck2)
                    ->count();

            if ($cek > 0) {
                if ($statusCheck1 == "send" && $statusCheck2 == "edit") {
                    array_push($tableList,$val);
                } else {
                    array_push($tableListArea,$val);
                }
            }
        }

        #Transfer Data Pusat <-> Waroeng
        if (count($tableList) > 0) {
            #Get List Destination to Sync
            $dest = DB::table('db_con')->where('db_con_data_status','destination');
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
                    $cekConn = DB::connection($connName)->getDatabaseName();

                    $status = '';
                    if (!empty($cekConn)) {
                        $status = 'connect';
                        $DbDest = DB::connection($connName);
                    }else {
                        $status = 'disconnect';
                    }
                    DB::table('db_con')->where('db_con_id',$valDest->db_con_id)
                    ->update([
                        'db_con_network_status' => $status
                    ]);
                } catch (\Exception $e) {
                    $errorConnCounter += 1;
                    // die("Could not connect to the database. Error:" . $e );
                    info("Could not connect to Destination. Error:" . $e);
                    #skip executing on error connection
                    continue;
                }

                $errorTableCounter = 0;
                foreach ($tableList as $keyTab => $valTab) {
                    #get Schema Table From resource
                    $sourceSchema = Schema::connection('source')->getColumnListing($valTab->config_sync_table_name);
                    $destSchema = Schema::connection($connName)->getColumnListing($valTab->config_sync_table_name);
                    if (count($sourceSchema) != count($destSchema)) {
                        $errorTableCounter++;
                        #SKIP
                        continue;
                    }

                    $statusCheck1 = "send";
                    $statusCheck2 = "edit";
                    $fieldStatus = $valTab->config_sync_field_status;
                    #Get data from source
                    $getDataSource = $DbSource->table($valTab->config_sync_table_name);
                    if ($valTab->config_sync_truncate == "tidak") {
                        $getDataSource->where($fieldStatus,$statusCheck1);
                        $getDataSource->orWhere($fieldStatus,$statusCheck2);
                        $getDataSource->limit($valTab->config_sync_limit);
                    }
                    // $getDataSource->get();

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
                                info("Can't insert to {$valTab->config_sync_table_name}");
                                info("Error:" . $th);
                                continue;
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
                                info("Can't update to {$valTab->config_sync_table_name}");
                                info("Error:" . $th);
                                continue;
                            }

                        }
                    }

                }
                $counterConn++;
            }
        }

        #Transfer Data Pusat -> Area
        if ($tableListArea > 0) {
            foreach ($tableListArea as $keyTab => $valTab) {
                # code...
            }
        }
        info("Cron Job Data Transfer Success at ". now());

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
}
