<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class DuplicateMasterCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'duplicatemaster:cron';

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
                    ->where('cronjob_name','duplicatemaster:cron')
                    ->first();

        if (!empty($cronStatus)) {
            if ($cronStatus->cronjob_status == 'open') {
                Log::info("Cronjob DUPLICATE MASTER START at ". Carbon::now()->format('Y-m-d H:i:s'));
            }else{
                Log::info("Cronjob DUPLICATE MASTER CLOSED");
                return Command::SUCCESS;
            }
        }else{
            Log::info("Cronjob DUPLICATE MASTER CLOSED");
            return Command::SUCCESS;
        }

        #get sipedas local connection
        $getLocalSipedas = DB::table('db_con')
            ->where('db_con_host','127.0.0.1')
            ->first();

        Config::set("database.connections.sipedaslocal", [
            'driver' => $getLocalSipedas->db_con_driver,
            'host' => $getLocalSipedas->db_con_host,
            'port' => $getLocalSipedas->db_con_port,
            'database' => $getLocalSipedas->db_con_dbname,
            'username' => $getLocalSipedas->db_con_username,
            'password' => Helper::customDecrypt($getLocalSipedas->db_con_password),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ]);

        try {
            $cekConn = Schema::connection('sipedaslocal')->hasTable('users');

            $status = '';
            if ($cekConn) {
                $status = 'connect';
                $DbSipedasLocal = DB::connection('sipedaslocal');

                DB::table('db_con')->where('db_con_id',$getLocalSipedas->db_con_id)
                    ->update([
                        'db_con_network_status' => $status
                    ]);
            }

        } catch (\Exception $e) {
            Log::info("duplicatemaster:Cron Could not connect to local database. Error:" . $e);
            DB::table('db_con')->where('db_con_id',$getLocalSipedas->db_con_id)
            ->update([
                'db_con_network_status' => 'disconnect'
            ]);
            return Command::SUCCESS;
        }

        $getTableList = DB::connection('cronpusat')
            ->table('config_sync')
            ->where('config_sync_for',env('SERVER_TYPE',''))
            ->where('config_sync_tipe','duplicatemaster')
            ->where('config_sync_status','on')
            ->orderBy('config_sync_id','asc')
            ->get();

        if (empty($getTableList)) {
            Log::info("Cronjob DUPLICATE MASTER - List Table to Check Not Found");
            return Command::SUCCESS;
        }

        foreach ($getTableList as $key => $valTab) {
            $except = array('app_setting','role_has_permissions','model_has_permissions','model_has_roles');

            $groupValidation = [];
            for ($i=1; $i <= 4; $i++) {
                $validate = "config_sync_field_validate{$i}";
                $validateField = $valTab->$validate;
                if (!empty($validateField)) {
                    array_push($groupValidation,$validateField);
                }
            }
            $incId = 'id';
            if (in_array($valTab->config_sync_table_name,$except)) {
                $incId = $valTab->config_sync_field_pkey;
            }

            $maxId = $DbSipedasLocal->table($valTab->config_sync_table_name)
                ->selectRaw("MAX({$incId}) as id, MAX({$valTab->config_sync_field_pkey}) as pkey")
                ->orderBy($incId,'asc')
                ->groupBy($groupValidation)
                ->havingRaw('COUNT(*) > 1')
                ->get();

            if ($maxId->count() > 0) {
                #GET child of table
                $getChild = DB::connection('cronpusat')
                    ->table('config_parent')
                    ->where('config_parent_name',$valTab->config_sync_table_name)
                    ->where('config_parent_status','on')
                    ->orderBy('config_parent_id','asc')
                    ->get();

                $count = 0;
                $deleteId = [];
                $deletePkey = [];
                foreach ($maxId as $key => $valId) {
                    array_push($deleteId,$valId->id);
                    array_push($deletePkey,$valId->pkey);
                    $count++;
                }
                #Delete Child
                if ($getChild->count() > 0) {
                    foreach ($getChild as $keyChild => $valChild) {
                        try {
                            $DbSipedasLocal->table($valChild->config_parent_child_name)
                            ->whereIn($valChild->config_parent_child_fkey,$deletePkey)
                            ->delete();
                        } catch (\Throwable $th) {
                            Log::info("Cronjob DUPLICATE MASTER : Can't Delete data from child table {$valChild->config_parent_child_name}. Error:" . $th);
                            continue;
                        }

                    }
                }
                #Delete Duplicate
                try {
                    $DbSipedasLocal->table($valTab->config_sync_table_name)
                    ->whereIn('id',$deleteId)
                    ->delete();
                } catch (\Throwable $th) {
                    Log::info("Cronjob DUPLICATE MASTER : Can't Delete data from table {$valTab->config_sync_table_name}. Error:" . $th);
                    continue;
                }

                Log::info("Cronjob DUPLICATE MASTER : {$count} records have been deleted from {$valTab->config_sync_table_name}");

            }else{
                Log::info("Cronjob DUPLICATE MASTER : Table {$valTab->config_sync_table_name} is GOOD!");
            }

        }

        Log::info("Cronjob DUPLICATE MASTER FINISH at ". Carbon::now()->format('Y-m-d H:i:s'));

        return Command::SUCCESS;
    }
}
