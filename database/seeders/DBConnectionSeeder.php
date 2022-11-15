<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;


class DBConnectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('db_connection')->insert([
            'db_connection_client_code' => '1',
            'db_connection_host' => '127.0.0.1',
            'db_connection_port' => '5432',
            'db_connection_dbname' => 'sipedas_v4',
            'db_connection_username' => 'ihsanmac',
            'db_connection_password' => Crypt::encryptString('jankrik404'),
        ]);

        DB::table('db_connection')->insert([
            'db_connection_client_code' => '2',
            'db_connection_host' => '192.168.88.4',
            'db_connection_port' => '5432',
            'db_connection_dbname' => 'sipedas_v4',
            'db_connection_username' => 'adminweb',
            'db_connection_password' => Crypt::encryptString('TC@gjrk:55DB'),
        ]);
    }
}
