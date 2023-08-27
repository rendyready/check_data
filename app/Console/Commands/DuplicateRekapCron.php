<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class DuplicateRekapCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'duplicaterekap:cron';

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
                    ->where('cronjob_name','duplicaterekap:cron')
                    ->first();

        if (!empty($cronStatus)) {
            if ($cronStatus->cronjob_status == 'open') {
                Log::info("Cronjob DUPLICATE REKAP START at ". Carbon::now()->format('Y-m-d H:i:s'));
            }else{
                Log::info("Cronjob DUPLICATE REKAP CLOSED");
                return Command::SUCCESS;
            }
        }else{
            Log::info("Cronjob DUPLICATE REKAP CLOSED");
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
            Log::info("duplicaterekap:Cron Could not connect to local database. Error:" . $e);
            DB::table('db_con')->where('db_con_id',$getLocalSipedas->db_con_id)
            ->update([
                'db_con_network_status' => 'disconnect'
            ]);
            return Command::SUCCESS;
        }

        $getTableList = DB::connection('cronpusat')
            ->table('config_sync')
            ->where('config_sync_for',env('SERVER_TYPE',''))
            ->where('config_sync_tipe','duplicaterekap')
            ->where('config_sync_status','on')
            ->orderBy('config_sync_id','asc')
            ->get();

        if ($getTableList->count() == 0) {
            Log::info("Cronjob DUPLICATE REKAP - List Table to Check Not Found");
            return Command::SUCCESS;
        }

        foreach ($getTableList as $key => $valTab) {
            $tableSchema = Schema::connection('sipedaslocal')->getColumnListing($valTab->config_sync_table_name);

            #get field name date create
            $fieldDate = '';
            foreach ($tableSchema as $keySchema => $valSchema) {
                if (substr($valSchema,-10) == 'created_at') {
                    $fieldDate = $valSchema;
                }
            }

            $groupValidation = [];
            for ($i=1; $i <= 4; $i++) {
                $validate = "config_sync_field_validate{$i}";
                $validateField = $valTab->$validate;
                if (!empty($validateField)) {
                    array_push($groupValidation,$validateField);
                }
            }
            $now = Carbon::now()->format('Y-m-d');
            $maxId = $DbSipedasLocal->table($valTab->config_sync_table_name)
                ->selectRaw("MAX(id) as id, MAX({$valTab->config_sync_field_pkey}) as pkey")
                ->whereRaw("{$fieldDate}::TEXT LIKE '{$now}%'")
                ->orderBy('id','asc')
                ->groupBy($groupValidation)
                ->havingRaw('COUNT(*) > 1')
                ->get();

            if ($maxId->count() > 0) {
                #GET child of table
                $getChild = DB::connection('cronpusat')
                    ->table('config_parent')
                    ->where('config_parent_name',$valTab->config_sync_table_name)
                    ->where('config_parent_status','on')
                    ->orderBy('config_parent_id','asc');

                $childCount = $getChild->count();

                #Delete Child
                if ($childCount > 0) {
                    $unDeletePkey = [];
                    $deletePkey = [];
                    $deleteId = [];
                    foreach ($maxId as $key => $valMax) {
                        $childCroscheck = 0;
                        foreach ($getChild->get() as $keyChild => $valChild) {
                            $cek = $DbSipedasLocal->table($valChild->config_parent_child_name)
                            ->where($valChild->config_parent_child_fkey,$valMax->pkey)->count();
                            if ($cek > 0) {
                                $childCroscheck++;
                            }
                        }

                        if ($childCount != $childCroscheck) {
                            array_push($deletePkey,$valMax->pkey);
                            array_push($deleteId,$valMax->id);
                        }else{
                            array_push($unDeletePkey,$valMax->pkey);
                        }
                    }

                    if (count($unDeletePkey) > 0) {
                        $minId = $DbSipedasLocal->table($valTab->config_sync_table_name)
                        ->selectRaw("MIN(id) as id, MIN({$valTab->config_sync_field_pkey}) as pkey")
                        ->whereRaw("{$fieldDate}::TEXT LIKE '{$now}%'")
                        ->orderBy('id','asc')
                        ->groupBy($groupValidation)
                        ->havingRaw('COUNT(*) > 1')
                        ->get();

                        foreach ($minId as $key => $valMin) {
                            $childCroscheck = 0;
                            foreach ($getChild->get() as $keyChild => $valChild) {
                                $cek = $DbSipedasLocal->table($valChild->config_parent_child_name)
                                ->where($valChild->config_parent_child_fkey,$valMin->pkey)->count();
                                if ($cek > 0) {
                                    $childCroscheck++;
                                }
                            }

                            if ($childCount != $childCroscheck) {
                                array_push($deletePkey,$valMin->pkey);
                                array_push($deleteId,$valMin->id);
                            }
                        }
                    }

                    if (count($deletePkey) > 0) {
                        foreach ($getChild->get() as $keyChild => $valChild) {
                            try {
                                $countChildToDel = $DbSipedasLocal->table($valChild->config_parent_child_name)
                                ->whereIn($valChild->config_parent_child_fkey,$deletePkey)
                                ->count();

                                $DbSipedasLocal->table($valChild->config_parent_child_name)
                                ->whereIn($valChild->config_parent_child_fkey,$deletePkey)
                                ->delete();

                                Log::info("Cronjob DUPLICATE REKAP : {$countChildToDel} records have been deleted from child table {$valChild->config_parent_child_name}");
                            } catch (\Throwable $th) {
                                Log::info("Cronjob DUPLICATE REKAP : Can't Delete data from child table {$valChild->config_parent_child_name}. Error:" . $th);
                                continue;
                            }

                        }
                    }
                }else{
                    $deleteId = [];
                    foreach ($maxId as $key => $valId) {
                        array_push($deleteId,$valId->id);
                    }
                }

                #Delete Parent Duplicate
                try {
                    $count = count($deleteId);

                    $DbSipedasLocal->table($valTab->config_sync_table_name)
                    ->whereIn('id',$deleteId)
                    ->delete();

                    Log::info("Cronjob DUPLICATE REKAP : {$count} records have been deleted from {$valTab->config_sync_table_name}");
                } catch (\Throwable $th) {
                    Log::info("Cronjob DUPLICATE REKAP : Can't Delete data from table {$valTab->config_sync_table_name}. Error:" . $th);
                    continue;
                }
            }else{
                Log::info("Cronjob DUPLICATE REKAP : Table {$valTab->config_sync_table_name} is GOOD!");
            }

        }

        Log::info("Cronjob DUPLICATE REKAP FINISH at ". Carbon::now()->format('Y-m-d H:i:s'));

        return Command::SUCCESS;
    }
}
