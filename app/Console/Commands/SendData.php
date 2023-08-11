<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class SendData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'senddata:cron';

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
        #Cek cronjob status on Local
        $cronStatus = DB::table('cronjob')
                    ->where('cronjob_name','senddata:cron')
                    ->first();

        if (!empty($cronStatus)) {
            if ($cronStatus->cronjob_status == 'open') {
                Log::info("Cronjob SEND Data START at ". Carbon::now()->format('Y-m-d H:i:s'));
            }else{
                Log::info("Cronjob SEND Data CLOSED");
                return Command::SUCCESS;
            }
        }else{
            Log::info("Cronjob SEND Data CLOSED");
            return Command::SUCCESS;
        }

        #get source
        $getSourceConn = DB::table('db_con')
            ->where('db_con_sync_status','on')
            ->where('db_con_senddata_status','source')
            ->first();

        if (empty($getSourceConn)) {
            Log::info("Cronjob SEND Data, SOURCE NOT ACTIVE");
            return Command::SUCCESS;
        }

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
            Log::info("Could not connect to the SOURCE database. Error:" . $e);
            DB::table('db_con')->where('db_con_id',$getSourceConn->db_con_id)
            ->update([
                'db_con_network_status' => 'disconnect'
            ]);
            return Command::SUCCESS;
        }

        #GET Destination
        $dest = DB::table('db_con')
        ->where('db_con_sync_status','on')
        ->where('db_con_senddata_status','target')
        ->get();

        if (empty($dest)) {
            Log::info("Cronjob SEND Data, ALL Target NOT ACTIVE");
            return Command::SUCCESS;
        }

        $getTableList = DB::connection('cronpusat')
            ->table('config_sync')
            ->where('config_sync_for',env('SERVER_TYPE',''))
            ->where('config_sync_tipe','send')
            ->where('config_sync_status','on')
            ->orderBy('config_sync_id','asc')
            ->get();

        foreach ($dest as $keyDest => $valDest) {
            #GET Data is open from this destination?
            $getDataOpen = DB::connection('cronpusat')
            ->table('db_con')
            ->where('db_con_host',$valDest->db_con_host)
            ->first();

            if (!empty($getDataOpen)) {
                if ($getDataOpen->db_con_sync_status == 'off') {
                    Log::alert("SEND DATA To {$valDest->db_con_location_name} NOT ALLOWED FROM PUSAT.");
                    continue;
                }
            }else{
                Log::alert("SEND DATA SETUP To {$valDest->db_con_location_name} NOT FOUND.");
                continue;
            }

            Config::set("database.connections.destination", [
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
                $cekConn = Schema::connection('destination')->hasTable('users');

                $status = '';
                if ($cekConn) {
                    $status = 'connect';
                    $DbDest = DB::connection('destination');
                    DB::table('db_con')->where('db_con_id',$valDest->db_con_id)
                    ->update([
                        'db_con_network_status' => $status
                    ]);
                }

            } catch (\Exception $e) {
                Log::info("Could not connect to Destination. {$valDest->db_con_location_name} OFFLINE ");
                Log::alert("Error:" . $e);
                DB::table('db_con')->where('db_con_id',$valDest->db_con_id)
                    ->update([
                        'db_con_network_status' => 'disconnect'
                    ]);
                #skip executing on error connection
                continue;
            }

            $serverCode = ":{$valDest->db_con_m_w_id}:";

            foreach ($getTableList as $key => $valTab) {
                #get Schema Table From resource
                $sourceSchema = Schema::connection('source')->getColumnListing($valTab->config_sync_table_name);
                $destSchema = Schema::connection('destination')->getColumnListing($valTab->config_sync_table_name);
                if (count($sourceSchema) != count($destSchema)) {
                    info("Table {$valTab->config_sync_table_name} structur of DESTINATION {$valDest->db_con_host} EXPIRED");
                    #SKIP
                    continue;
                }

                if ($valTab->config_sync_sequence == 'on') {
                    #Get Last Increment Used
                    $maxId = $DbDest->select("SELECT MAX(id) FROM {$valTab->config_sync_table_name};")[0]->max;

                    #GET Current Increment of table (Recomended method)
                    $currentId = $DbDest->select("SELECT last_value FROM {$valTab->config_sync_table_name}_id_seq;")[0]->last_value;
                    if (empty($maxId)) {
                        if ($currentId > 1) {
                            $DbDest->select("SELECT setval('{$valTab->config_sync_table_name}_id_seq', 1);");
                        }
                    }else{
                        if ($maxId != $currentId) {
                            $DbDest->select("SELECT setval('{$valTab->config_sync_table_name}_id_seq', {$maxId});");
                        }
                    }
                }

                $fieldStatus = $valTab->config_sync_field_status;
                $getDataSource = $DbSource->table($valTab->config_sync_table_name);

                if ($valTab->config_sync_truncate == "off") {
                    $getDataSource->where($fieldStatus,"LIKE","%{$serverCode}%");
                    $getDataSource->orderBy($valTab->config_sync_field_validate1,'asc');
                    if ($valTab->config_sync_limit > 0) {
                        $getDataSource->limit($valTab->config_sync_limit);
                    }
                }

                if ($valTab->config_sync_truncate == "on" && $valTab->config_sync_table_tipe == "master") {
                    $DbDest->statement("TRUNCATE TABLE {$valTab->config_sync_table_name} RESTART IDENTITY;");
                }

                #PUSH data to Destination
                if ($getDataSource->get()->count() > 0) {
                    foreach ($getDataSource->get() as $keyDataSource => $valDataSource) {
                        $data = [];
                        foreach ($sourceSchema as $keySchema => $valSchema) {
                            if ($valSchema != 'id') {
                                if ($valSchema == $valTab->config_sync_field_status) {
                                    $data[$valSchema] = str_replace($serverCode,'',$valDataSource->$valSchema);
                                } else {
                                    $data[$valSchema] = $valDataSource->$valSchema;
                                }
                            }
                        }
                        $validationField = [];
                        $groupValidation = [];
                        for ($i=1; $i <= 4; $i++) {
                            $validate = "config_sync_field_validate{$i}";
                            $validateField = $valTab->$validate;
                            if (!empty($validateField)) {
                                $validationField[$validateField] = $valDataSource->$validateField;
                                array_push($groupValidation,$validateField);
                            }
                        }

                        try {
                            $cekReady = $DbDest->table($valTab->config_sync_table_name)
                            ->where($validationField)->count();

                            $save = $DbDest->table($valTab->config_sync_table_name);
                            if ($cekReady == 0) {
                                $save->insert($data);
                            }else{
                                $save->where($validationField)->update($data);
                            }

                            if ($save) {
                                $replace = [];
                                $replace[$fieldStatus] = DB::raw("REPLACE({$fieldStatus},'{$serverCode}','')");
                                $DbSource->table($valTab->config_sync_table_name)
                                ->where($validationField)
                                ->update(
                                    $replace
                                );
                            }

                            #control duplicate
                            $except = array('app_setting','role_has_permissions','model_has_permissions','model_has_roles');
                            if ($cekReady > 1 && !in_array($valTab->config_sync_table_name,$except)) {
                                $maxId = $DbDest->table($valTab->config_sync_table_name)
                                    ->selectRaw("MAX(id) as id")
                                    ->where($validationField)
                                    ->orderBy('id','asc')
                                    ->groupBy($groupValidation)
                                    ->havingRaw('COUNT(*) > 1')
                                    ->get();

                                $deleteId = [];
                                foreach ($maxId as $key => $valId) {
                                    array_push($deleteId,$valId->id);
                                }
                                #Delete Duplicate
                                $DbDest->table($valTab->config_sync_table_name)
                                    ->whereIn('id',$deleteId)
                                    ->delete();
                            }

                        } catch (\Throwable $th) {
                            Log::alert("Can't insert/update to {$valTab->config_sync_table_name}");
                            Log::info($th);
                        }
                    }
                }
            }

        }

        Log::info("Cronjob GET Data FINISH at ". Carbon::now()->format('Y-m-d H:i:s'));

        return Command::SUCCESS;
    }
}
