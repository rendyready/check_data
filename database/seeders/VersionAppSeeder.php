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
        DB::statement("TRUNCATE TABLE version_app RESTART IDENTITY;");
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

        DB::statement("TRUNCATE TABLE instuction_update RESTART IDENTITY;");

        DB::table('instuction_update')->insert([
            'instuction_update_app_name' => 'sipedas',
            'instuction_update_base_path' => 'sipedas.wss',
            'instuction_update_syntax' => 'git reset --hard',
            'instuction_update_order' => '1'
        ]);
        DB::table('instuction_update')->insert([
            'instuction_update_app_name' => 'sipedas',
            'instuction_update_base_path' => 'sipedas.wss',
            'instuction_update_syntax' => 'git pull origin develop',
            'instuction_update_order' => '2'
        ]);
        DB::table('instuction_update')->insert([
            'instuction_update_app_name' => 'sipedas',
            'instuction_update_base_path' => 'sipedas.wss',
            'instuction_update_syntax' => 'composer dump-autoload',
            'instuction_update_order' => '3'
        ]);
        DB::table('instuction_update')->insert([
            'instuction_update_app_name' => 'sipedas',
            'instuction_update_base_path' => 'sipedas.wss',
            'instuction_update_syntax' => 'php artisan migrate',
            'instuction_update_order' => '4'
        ]);
        DB::table('instuction_update')->insert([
            'instuction_update_app_name' => 'sipedas',
            'instuction_update_base_path' => 'sipedas.wss',
            'instuction_update_syntax' => 'npm run build',
            'instuction_update_order' => '5'
        ]);
        DB::table('instuction_update')->insert([
            'instuction_update_app_name' => 'api',
            'instuction_update_base_path' => 'api.sipedas.wss',
            'instuction_update_syntax' => 'git reset --hard',
            'instuction_update_order' => '1'
        ]);
        DB::table('instuction_update')->insert([
            'instuction_update_app_name' => 'api',
            'instuction_update_base_path' => 'api.sipedas.wss',
            'instuction_update_syntax' => 'git pull origin production',
            'instuction_update_order' => '2'
        ]);
        DB::table('instuction_update')->insert([
            'instuction_update_app_name' => 'api',
            'instuction_update_base_path' => 'api.sipedas.wss',
            'instuction_update_syntax' => 'composer dump-autoload',
            'instuction_update_order' => '3'
        ]);
        DB::table('instuction_update')->insert([
            'instuction_update_app_name' => 'cr55',
            'instuction_update_base_path' => 'cr55.wss',
            'instuction_update_syntax' => 'git reset --hard',
            'instuction_update_order' => '1'
        ]);
        DB::table('instuction_update')->insert([
            'instuction_update_app_name' => 'cr55',
            'instuction_update_base_path' => 'cr55.wss',
            'instuction_update_syntax' => 'git pull origin production',
            'instuction_update_order' => '2'
        ]);
        DB::table('instuction_update')->insert([
            'instuction_update_app_name' => 'cronjob',
            'instuction_update_base_path' => 'cronjob.wss',
            'instuction_update_syntax' => 'git reset --hard',
            'instuction_update_order' => '1'
        ]);
        DB::table('instuction_update')->insert([
            'instuction_update_app_name' => 'cronjob',
            'instuction_update_base_path' => 'cronjob.wss',
            'instuction_update_syntax' => 'git pull origin main',
            'instuction_update_order' => '2'
        ]);
    }
}
