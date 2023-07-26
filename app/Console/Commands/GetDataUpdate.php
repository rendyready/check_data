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

        // info("Cronjob GET Data-Cek Connection");

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

        $serverCode = ":{$dest->db_con_m_w_id}:";
        // info("Cronjob GET Data - Get List Table");
        $getTableList = DB::table('config_get_data')
                        ->where('config_get_data_status','on')
                        ->orderBy('config_get_data_id','asc')
                        ->get();

        foreach ($getTableList as $key => $valTab) {
            // info("Cronjob GET Data - Get Data ".$valTab->config_get_data_table_name);

            #get Schema Table From resource
            $sourceSchema = Schema::connection('source')->getColumnListing($valTab->config_get_data_table_name);
            $destSchema = Schema::connection('destination')->getColumnListing($valTab->config_get_data_table_name);
            if (count($sourceSchema) != count($destSchema)) {
                info("DB structur of DESTINATION EXPIRED");
                #SKIP
                exit();
            }

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

            $fieldStatus = $valTab->config_get_data_field_status;
            $priorityList = [];
            if ($valTab->config_get_data_table_name == "m_menu_harga") {
                $prioritySource = $DbSource->table($valTab->config_get_data_table_name)
                    ->join('m_jenis_nota','m_jenis_nota_id','=','m_menu_harga_m_jenis_nota_id')
                    ->where('m_jenis_nota_m_w_id',$dest->db_con_m_w_id)
                    ->where($fieldStatus,"LIKE","%{$serverCode}%")
                    ->orderBy($valTab->config_get_data_field_validate1,'asc');
                    if ($valTab->config_get_data_limit > 0) {
                        $prioritySource->limit($valTab->config_get_data_limit);
                    }

                if ($prioritySource->get()->count() > 0) {
                    foreach ($prioritySource->get() as $keyP => $valP) {
                        array_push($priorityList,$valP->m_menu_harga_id);
                    }
                }
            }
            $getDataSource = $DbSource->table($valTab->config_get_data_table_name);
            if (count($priorityList) > 0) {
                $getDataSource->whereIn('m_menu_harga_id',$priorityList);
            }
            if ($valTab->config_get_data_truncate == "off") {
                $getDataSource->where($fieldStatus,"LIKE","%{$serverCode}%");
                $getDataSource->orderBy($valTab->config_get_data_field_validate1,'asc');
                if ($valTab->config_get_data_limit > 0) {
                    $getDataSource->limit($valTab->config_get_data_limit);
                }
            }

            if ($valTab->config_get_data_truncate == "on" && $valTab->config_get_data_table_tipe == "master") {
                $DbDest->statement("TRUNCATE TABLE {$valTab->config_get_data_table_name} RESTART IDENTITY;");
            }

            #PUSH data to Destination
            if ($getDataSource->get()->count() > 0) {
                foreach ($getDataSource->get() as $keyDataSource => $valDataSource) {
                    $newDestStatus = "";
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
                    $validationField = [];
                    for ($i=1; $i <= 4; $i++) {
                        $validate = "config_get_data_field_validate{$i}";
                        $validateField = $valTab->$validate;
                        if (!empty($validateField)) {
                            $validationField[$validateField] = $valDataSource->$validateField;
                        }
                    }

                    try {
                        // $save = $DbDest->table($valTab->config_get_data_table_name)
                        //     ->updateOrInsert(
                        //         $validationField,
                        //         $data
                        //     );
                        $cekReady = $DbDest->table($valTab->config_get_data_table_name)
                        ->where($validationField)->count();

                        $save = $DbDest->table($valTab->config_get_data_table_name);
                        if ($cekReady == 0) {
                            $save->insert($data);
                        }else{
                            $save->where($validationField)->update($data);
                        }

                        if ($save) {
                            $replace = [];
                            $replace[$fieldStatus] = DB::raw("REPLACE({$fieldStatus},'{$serverCode}','')");
                            $DbSource->table($valTab->config_get_data_table_name)
                            ->where($validationField)
                            ->update(
                                $replace
                            );
                        }
                    } catch (\Throwable $th) {
                        Log::alert("Can't insert/update to {$valTab->config_get_data_table_name}");
                        Log::info($th);
                    }
                }
            }
        }

        Log::info("Cronjob GET Data FINISH at ". Carbon::now()->format('Y-m-d H:i:s'));

        return Command::SUCCESS;
    }
}