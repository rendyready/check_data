<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CronjobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("TRUNCATE TABLE cronjob RESTART IDENTITY;");

        DB::table('cronjob')->insert([
            'cronjob_name' => 'getdata:cron',
            // 'cronjob_status' => 'close'
        ]);
        DB::table('cronjob')->insert([
            'cronjob_name' => 'senddata:cron',
            // 'cronjob_status' => 'close'
        ]);
        DB::table('cronjob')->insert([
            'cronjob_name' => 'duplicatemaster:cron',
            // 'cronjob_status' => 'close'
        ]);
        DB::table('cronjob')->insert([
            'cronjob_name' => 'duplicaterekap:cron',
            // 'cronjob_status' => 'close'
        ]);
        DB::table('cronjob')->insert([
            'cronjob_name' => 'version:cron',
            // 'cronjob_status' => 'close'
        ]);

        DB::table('cronjob')->insert([
            'cronjob_name' => 'datasync:cron'
        ]);

        DB::table('cronjob')->insert([
            'cronjob_name' => 'autoshutdown:cron',
            // 'cronjob_status' => 'close'
        ]);
        DB::table('cronjob')->insert([
            'cronjob_name' => 'resetlog:cron',
            // 'cronjob_status' => 'close'
        ]);
        DB::table('cronjob')->insert([
            'cronjob_name' => 'getdataupdate:cron',
            // 'cronjob_status' => 'close'
        ]);
        DB::table('cronjob')->insert([
            'cronjob_name' => 'sendcloud:cron',
            'cronjob_status' => 'close'
        ]);
        DB::table('cronjob')->insert([
            'cronjob_name' => 'mastercontrol:cron',
            'cronjob_status' => 'open'
        ]);
        DB::table('cronjob')->insert([
            'cronjob_name' => 'sendserverstatus:cron',
            'cronjob_status' => 'open'
        ]);
        DB::table('cronjob')->insert([
            'cronjob_name' => 'countdataserver:cron',
            'cronjob_status' => 'close'
        ]);
    }
}
