<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VersionAppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('version_app')->insert([
            'version_app_name' => 'sipedas',
            'version_app_code' => '04.2305.01'
        ]);
        DB::table('version_app')->insert([
            'version_app_name' => 'api',
            'version_app_code' => '04.2305.01'
        ]);
        DB::table('version_app')->insert([
            'version_app_name' => 'cr55',
            'version_app_code' => '04.2305.01'
        ]);
        DB::table('version_app')->insert([
            'version_app_name' => 'cronjob',
            'version_app_code' => '04.2305.01'
        ]);
    }
}
