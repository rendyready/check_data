<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class SendCloud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendcloud:cron';

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
        Config::set("database.connections.destination", [
            'driver' => 'pgsql',
            'host' => 'dbwss.waroengss.com',
            'port' => '5432',
            'database' => 'admindb_penjualan_wss',
            'username' => 'admindb_penjualan55',
            'password' => 'Sales@55wss',
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
        return Command::SUCCESS;
    }
}
