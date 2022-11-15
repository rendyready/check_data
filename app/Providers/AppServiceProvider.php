<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Config DB Client Connection By jangkrik404
        // $clientConnection = DB::table('db_connection')->get(); //get data client

        // foreach ($clientConnection as $key => $value) {
        //     Config::set("database.connections.{$value->db_connection_client_code}", [
        //         'driver' => 'pgsql',
        //         'host' => $value->db_connection_host,
        //         'port' => $value->db_connection_port,
        //         'database' => $value->db_connection_dbname,
        //         'username' => $value->db_connection_username,
        //         'password' => Crypt::decryptString($value->db_connection_password),
        //         'charset' => 'utf8',
        //         'prefix' => '',
        //         'prefix_indexes' => true,
        //         'search_path' => 'public',
        //         'sslmode' => 'prefer',
        //      ]);
        // }
    }
}
