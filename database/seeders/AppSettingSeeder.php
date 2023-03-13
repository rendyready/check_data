<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('app_setting')->truncate();

        DB::table('app_setting')->insert([
            [
                'app_setting_m_w_id' => 35,
                'app_setting_key_wa' => 'c70163fb3858b483ee80c796347bce5b',
                'app_setting_device_wa' => '08112826619',
                'app_setting_url_server_struk' => 'https://struk.pedasabis.com/api/image',
                'app_setting_key_server_struk' => 'aD1UnchysFUfRHMqi61TWiZT7gjAFNAmnDrjkUFvVgrXIJplWasWvylDuZismZnO',
                'app_setting_created_by' => 1,
            ]
        ]);
    }
}
