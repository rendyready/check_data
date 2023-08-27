<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CronjobSeeder::class
        ]);

        DB::table('db_con')->where('db_con_location','pusat')
        ->update([
            'db_con_sync_status' => 'on',
            'db_con_getdata_status' => 'source',
            'db_con_senddata_status' => 'target',
        ]);
        DB::table('db_con')->whereIn('db_con_location',['waroeng','area'])
        ->update([
            'db_con_sync_status' => 'on',
            'db_con_getdata_status' => 'target',
            'db_con_senddata_status' => 'source',
        ]);
    }
}
