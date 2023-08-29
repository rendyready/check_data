<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PusatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ConfigSyncMasterSeeder::class,
            ConfigSyncRekapSeeder::class,
            ConfigDuplicateMasterSeeder::class,
            ConfigDuplicateRekapSeeder::class,
            ConfigMasterControllSeeder::class,
            ConfigParentSeeder::class,
            VersionAppSeeder::class,
            // CronjobSeeder::class
        ]);

        DB::statement("TRUNCATE TABLE cronjob RESTART IDENTITY;");

        DB::table('cronjob')->insert([
            'cronjob_name' => 'getdata:cron',
            'cronjob_status' => 'close'
        ]);
        DB::table('cronjob')->insert([
            'cronjob_name' => 'senddata:cron',
            'cronjob_status' => 'close'
        ]);
        DB::table('cronjob')->insert([
            'cronjob_name' => 'duplicatemaster:cron',
            'cronjob_status' => 'open'
        ]);
        DB::table('cronjob')->insert([
            'cronjob_name' => 'duplicaterekap:cron',
            'cronjob_status' => 'open'
        ]);
        DB::table('cronjob')->insert([
            'cronjob_name' => 'version:cron',
            'cronjob_status' => 'close'
        ]);

        DB::table('cronjob')->insert([
            'cronjob_name' => 'resetlog:cron',
            'cronjob_status' => 'open'
        ]);

        DB::table('cronjob')->insert([
            'cronjob_name' => 'sendcloud:cron',
            'cronjob_status' => 'close'
        ]);

        DB::table('cronjob')->insert([
            'cronjob_name' => 'mastercontroll:cron',
            'cronjob_status' => 'close'
        ]);
        DB::table('cronjob')->insert([
            'cronjob_name' => 'sendserverstatus:cron',
            'cronjob_status' => 'close'
        ]);
        DB::table('cronjob')->insert([
            'cronjob_name' => 'countdataserver:cron',
            'cronjob_status' => 'open'
        ]);

        DB::table('db_con')->where('db_con_sync_status','aktif')
        ->update([
            'db_con_sync_status' => 'on'
        ]);
        DB::table('db_con')->where('db_con_sync_status','tidak')
        ->update([
            'db_con_sync_status' => 'off'
        ]);
    }
}
