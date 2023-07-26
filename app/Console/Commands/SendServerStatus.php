<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class SendServerStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendserverstatus:cron';

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
            ->where('cronjob_name', 'sendserverstatus:cron')
            ->first();
        if ($cronStatus->cronjob_status == 'open') {
            info("Cronjob Send Status Server START at " . Carbon::now()->format('Y-m-d H:i:s'));
        } else {
            return Command::SUCCESS;
        }

        #get source
        $getSourceConn = DB::table('db_con')
            ->where('db_con_location', 'pusat')
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

                DB::table('db_con')->where('db_con_id', $getSourceConn->db_con_id)
                    ->update([
                        'db_con_network_status' => $status,
                    ]);
            }

        } catch (\Exception $e) {
            info("Could not connect to the SOURCE database. Error:" . $e);
            DB::table('db_con')->where('db_con_id', $getSourceConn->db_con_id)
                ->update([
                    'db_con_network_status' => 'disconnect',
                ]);
            exit();
        }

        #GET Destination
        $dest = DB::table('db_con')->whereIn('db_con_location', ['waroeng', 'area'])
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
                DB::table('db_con')->where('db_con_id', $dest->db_con_id)
                    ->update([
                        'db_con_network_status' => $status,
                    ]);
            }

        } catch (\Exception $e) {
            info("Could not connect to Destination. Error:" . $e);
            DB::table('db_con')->where('db_con_id', $dest->db_con_id)
                ->update([
                    'db_con_network_status' => 'disconnect',
                ]);
            #skip executing on error connection
            exit();
        }
            $sourceSchema = Schema::connection('source')->getColumnListing('m_w');
            $destSchema = Schema::connection('destination')->getColumnListing('m_w');
            if (count($sourceSchema) != count($destSchema)) {
                info("DB structur of DESTINATION EXPIRED");
                #SKIP
                exit();
            }

        //update_status_server Pusat
        try {
            $DbSource->table('m_w')
                ->where('m_w_id', $dest->db_con_m_w_id)
                ->update(['m_w_server_status' => Carbon::now()->format('Y-m-d H:i:s')]);
        } catch (\Throwable $th) {
            Log::alert("Can't update Server Status");
            Log::info($th);
        }

        Log::info("Cronjob Send Server Status FINISH at " . Carbon::now()->format('Y-m-d H:i:s'));
        return Command::SUCCESS;
    }
}