<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class GetMaster extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getdata:cron';

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

            if ($valTab->config_get_data_truncate == "on" && $valTab->config_get_data_table_tipe == "master") {
                $DbDest->statement("TRUNCATE TABLE {$valTab->config_get_data_table_name} RESTART IDENTITY;");
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

            #PUSH data to Destination
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
        #Local Log
        DB::table('log_cronjob')
        ->insert([
            'log_cronjob_name' => 'getdata:cron',
            'log_cronjob_from_server_id' => $getSourceConn->db_con_m_w_id,
            'log_cronjob_from_server_name' => $getSourceConn->db_con_location_name,
            'log_cronjob_to_server_id' => $dest->db_con_m_w_id,
            'log_cronjob_to_server_name' => $dest->db_con_location_name,
            'log_cronjob_datetime' => Carbon::now(),
            'log_cronjob_note' => 'Sukses!',
        ]);
        Log::info("Cronjob GET Data FINISH at ". Carbon::now()->format('Y-m-d H:i:s'));

        return Command::SUCCESS;
    }
}
