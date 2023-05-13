<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SyncUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('config_sync')->insert([
            'config_sync_table_name' => 'users',
            'config_sync_table_tipe' => 'master',
            'config_sync_status' => 'aktif',
            'config_sync_limit' => 100,
            'config_sync_field_status' => 'users_status_sync',
            'config_sync_field_validate1' => 'users_id'
        ]);
    }
}
