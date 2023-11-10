<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;

class CountDataController extends Controller
{
    public function index()
    {
        return view('home');
    }
    public function show_data()
    {
        $data = new \stdClass();
        $data->area = DB::table('m_area')
            ->orderby('m_area_id', 'ASC')
            ->get();

        // return view('dashboard::dashboard');
        return view('show_data', compact('data'));
    }

    public function tampil(Request $request)
    {
        // return $request->tanggal;
        $check_data = DB::table('log_data_check');
        if (strpos($request->tanggal, 'to') !== false) {
            $dates = explode('to', $request->tanggal);
            $check_data->whereBetween('log_data_check_tanggal', $dates);
        } else {
            $check_data->where('log_data_check_tanggal', $request->tanggal);
        }
        $check_data = $check_data->orderBy('log_data_check_tanggal', 'ASC')
            ->get();

        $data = array();
        foreach ($check_data as $value) {
            $row = array();
            $row[] = date('d-m-Y', strtotime($value->log_data_check_tanggal));
            $row[] = $value->log_data_check_m_w_id;
            $row[] = $value->log_data_check_m_w_nama;
            $row[] = $value->log_data_check_table_nama;
            $row[] = $value->log_data_check_pusat;
            $row[] = $value->log_data_check_waroeng;
            $row[] = date('d-m-Y || H:i:s', strtotime($value->log_data_check_created_at));
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }

    public function check_data()
    {
        $data = new \stdClass();
        $data->area = DB::table('m_area')
            ->orderby('m_area_id', 'ASC')
            ->get();

        // return view('dashboard::dashboard');
        return view('check_data', compact('data'));
    }

    public function count_data()
    {
        // return 'berhasil masuk';
        #Cek cronjob status
        $cronStatus = DB::table('cronjob')
            ->where('cronjob_name', 'countdataserver:cron')
            ->first();
        if ($cronStatus->cronjob_status == 'open') {
            echo ("<b>Cronjob Check Data Server START at " . Carbon::now()->format('Y-m-d H:i:s') . " <br><br></b>");
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

        $getlist_master = DB::table('config_get_data')
            ->orderBy('config_get_data_id', 'asc')
            ->get();
        $getlist_rekap = DB::table('config_sync')
            ->orderBy('config_sync_id', 'asc')
        // ->where('config_sync_tipe', 'send')
            ->where('config_sync_table_tipe', 'transaksi')
            ->where('config_sync_status', 'on')
            ->get();
        $today = Carbon::now();
        // Mendapatkan tanggal kemarin
        $yesterday = $today->subDay();
        // Memformat tanggal kemarin menjadi "230713"
        $tanggal = $yesterday->format('ymd');
        // Get Destination Berdasarkan Log tidak Connet
        $getlist_dest = DB::table('log_data_check')
            ->where('log_data_check_table_nama', '!=', 'disconnect')
            ->where('log_data_check_tanggal', $yesterday)
            ->groupBy('log_data_check_m_w_id')
            ->pluck('log_data_check_m_w_id')
            ->toArray();

        // $jabo = ['7', '26'];
        // $purwokerto = ['28', '35'];
        // $semarang = ['37', '51'];
        // $perintis = ['71', '82'];
        // $jogja = ['53', '68'];
        // $solo = ['83', '100'];
        // $malang = ['102', '109'];
        // $bali = ['111', '115'];

        #GET Destination
        $dest = DB::table('db_con')
            ->whereIn('db_con_location', ['waroeng', 'area'])
            ->where('db_con_host', '!=', 'null')
            ->where('db_con_sync_status', 'on')
            ->whereNotIn('db_con_m_w_id', $getlist_dest)
        // ->whereBetween('db_con_m_w_id', $jogja)
        // ->where('db_con_m_w_id', '129')
            ->where('db_con_location', '!=', 'area')
            ->orderBy('db_con_id', 'ASC')
            ->get();

        $checkedTables = [];
        foreach ($dest as $key => $valDest) {
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

                $cekConn = Schema::connection($connName)->hasTable('users');

                $status = '';
                if ($cekConn) {
                    $status = 'connect';
                    $DbDest = DB::connection($connName);
                    DB::table('db_con')->where('db_con_id', $valDest->db_con_id)
                        ->update([
                            'db_con_network_status' => $status,
                        ]);
                }
            } catch (\Exception $e) {
                // die("Could not connect to the database. Error:" . $e );
                echo ("Could not connect to Destination {$valDest->db_con_location_name}. Error:" . $e);
                DB::table('db_con')->where('db_con_id', $valDest->db_con_id)
                    ->update([
                        'db_con_network_status' => 'disconnect',
                    ]);
                $datacon = [
                    'log_data_check_m_w_id' => $valDest->db_con_m_w_id,
                    'log_data_check_m_w_nama' => $valDest->db_con_location_name,
                    'log_data_check_table_nama' => "disconnet",
                    'log_data_check_pusat' => 0,
                    'log_data_check_waroeng' => 0,
                    'log_data_check_tanggal' => $yesterday,
                ];
                DB::table('log_data_check')->insert($datacon);
                #skip executing on error connection
                continue;
            }

            //count data master
            // foreach ($getlist_master as $master) {
            //     #get Schema Table From resource
            //     $sourceSchema = Schema::connection('source')->getColumnListing($master->config_get_data_table_name);
            //     $destSchema = Schema::connection($connName)->getColumnListing($master->config_get_data_table_name);
            //     if (count($sourceSchema) != count($destSchema)) {
            //         info("DB structur of master {$valDest->db_con_location_name} EXPIRED");
            //         #SKIP
            //         continue;
            //     }

            //     $countsource = $DbSource->table($master->config_get_data_table_name)
            //         ->count($master->config_get_data_field_validate1);
            //     $countdest = $DbDest->table($master->config_get_data_table_name)
            //         ->count($master->config_get_data_field_validate1);
            //     if ($countsource != $countdest) {
            //         $data = [
            //             'log_data_check_m_w_id' => $valDest->db_con_m_w_id,
            //             'log_data_check_m_w_nama' => $valDest->db_con_location_name,
            //             'log_data_check_table_nama' => $master->config_get_data_table_name,
            //             'log_data_check_pusat' => $countsource,
            //             'log_data_check_waroeng' => $countdest,
            //             'log_data_check_tanggal' => $yesterday,
            //         ];
            //         $DbSource->table('log_data_count')->insert($data);
            //     }
            // }

            foreach ($getlist_rekap as $rekap) {
                #get Schema Table From resource
                $sourceSchema = Schema::connection('source')->getColumnListing($rekap->config_sync_table_name);
                $destSchema = Schema::connection($connName)->getColumnListing($rekap->config_sync_table_name);
                if (count($sourceSchema) != count($destSchema)) {
                    info("DB structur of rekap {$valDest->db_con_location_name} EXPIRED");
                    #SKIP
                    continue;
                }

                $tableKey = $rekap->config_sync_table_name . ',' . $valDest->db_con_location_name;

                if (in_array($tableKey, $checkedTables)) {
                    continue; // Lanjutkan jika tabel ini sudah diperiksa sebelumnya
                }
                $checkedTables[] = $tableKey;

                $countsource = $DbSource->table($rekap->config_sync_table_name)
                    ->where(DB::raw("SPLIT_PART(" . $rekap->config_sync_field_validate1 . ", '.', 2)"), '=', "$valDest->db_con_m_w_id")
                    ->where(DB::raw("LEFT(SPLIT_PART(" . $rekap->config_sync_field_validate1 . ", '.', 5), 6)"), '=', "$tanggal")
                    ->count();
                // return $countsource;
                $countdest = $DbDest->table($rekap->config_sync_table_name)
                    ->where(DB::raw("SPLIT_PART(" . $rekap->config_sync_field_validate1 . ", '.', 2)"), '=', "$valDest->db_con_m_w_id")
                    ->where(DB::raw("LEFT(SPLIT_PART(" . $rekap->config_sync_field_validate1 . ", '.', 5), 6)"), '=', "$tanggal")
                    ->count();

                echo ("Pengecekan jumlah data table {$rekap->config_sync_table_name} {$valDest->db_con_location_name} DONE<br>");

                if ($countsource != $countdest) {

                    echo ("PERBEDAAN DATA table {$rekap->config_sync_table_name} {$valDest->db_con_location_name} FOUND <br>");
                    $data = [
                        'log_data_check_m_w_id' => $valDest->db_con_m_w_id,
                        'log_data_check_m_w_nama' => $valDest->db_con_location_name,
                        'log_data_check_table_nama' => $rekap->config_sync_table_name,
                        'log_data_check_pusat' => $countsource,
                        'log_data_check_waroeng' => $countdest,
                        'log_data_check_tanggal' => $yesterday,
                    ];
                    DB::table('log_data_check')->insert($data);

                    $replace = DB::raw("concat($rekap->config_sync_field_status, ':1:')");
                    $DbDest->table($rekap->config_sync_table_name)
                        ->where(DB::raw("SPLIT_PART(" . $rekap->config_sync_field_validate1 . ", '.', 2)"), '=', "$valDest->db_con_m_w_id")
                        ->update([
                            $rekap->config_sync_field_status => $replace,
                        ]);
                }
            }
        }

        echo ("<b><br>Cronjob Check Data Server FINISH at " . Carbon::now()->format('Y-m-d H:i:s') . "</b><br>");
        return Command::SUCCESS;
    }
}
