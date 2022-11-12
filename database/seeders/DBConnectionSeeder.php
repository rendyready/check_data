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
            'db_connection_name' => 'sipedas_v4',
            'db_connection_username' => 'ihsanmac',
            'db_connection_password' => Crypt::encryptString('password'),
        ]);
    }
}
