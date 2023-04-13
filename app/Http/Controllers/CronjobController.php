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
        //Config DB Client Connection By jangkrik500
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
}
