<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Helpers\Helper;


class DBConnectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("TRUNCATE TABLE db_con RESTART IDENTITY;");

        // DB::table('db_con')->insert([
        //     'db_con_m_w_id' => '1',
        //     'db_con_m_area_id' => '9',
        //     'db_con_location' => 'pusat',
        //     'db_con_location_name' => 'Kantor Kinanthi',
        //     'db_con_data_status' => 'destination',
        //     'db_con_sync_status' => 'aktif',
        //     'db_con_host' => '127.0.0.1',
        //     'db_con_port' => '5432',
        //     'db_con_dbname' => 'server_pusat',
        //     'db_con_username' => 'ihsanmac',
        //     'db_con_password' => Helper::customCrypt('jankrik404'),
        // ]);

        // DB::table('db_con')->insert([
        //     'db_con_m_w_id' => '58',
        //     'db_con_m_area_id' => '5',
        //     'db_con_location' => 'waroeng',
        //     'db_con_location_name' => 'wss jakal km 8',
        //     'db_con_data_status' => 'source',
        //     'db_con_sync_status' => 'aktif',
        //     'db_con_host' => '127.0.0.1',
        //     'db_con_port' => '5432',
        //     'db_con_dbname' => 'sipedas_jakal8',
        //     'db_con_username' => 'ihsanmac',
        //     'db_con_password' => Helper::customCrypt('jankrik404'),
        // ]);
        DB::table('db_con')->insert([
            'db_con_m_w_id' => '1',
            'db_con_m_area_id' => '9',
            'db_con_location' => 'pusat',
            'db_con_location_name' => 'Kantor Kinanthi',
            'db_con_data_status' => 'source',
            'db_con_sync_status' => 'aktif',
            'db_con_host' => '127.0.0.1',
            'db_con_port' => '5432',
            'db_con_dbname' => 'admin_sipedas_v4',
            'db_con_username' => 'admin_spesialw55',
            'db_con_password' => Helper::customCrypt('yoyokHW55'),
        ]);
        DB::table('db_con')->insert([
            'db_con_m_w_id' => '75',
            'db_con_m_area_id' => '4',
            'db_con_location' => 'waroeng',
            'db_con_location_name' => 'wss palagan',
            'db_con_data_status' => 'destination',
            'db_con_sync_status' => 'aktif',
            'db_con_host' => '192.168.255.28',
            'db_con_port' => '5432',
            'db_con_dbname' => 'admin_sipedas_v4',
            'db_con_username' => 'admin_root',
            'db_con_password' => Helper::customCrypt('Waroeng@55'),
        ]);

        // DB::table('db_con')->insert([
        //     'db_con_m_w_id' => '71',
        //     'db_con_m_area_id' => '4',
        //     'db_con_location' => 'area',
        //     'db_con_location_name' => 'Kantor Area Perintis',
        //     'db_con_data_status' => 'destination',
        //     'db_con_sync_status' => 'aktif',
        //     'db_con_host' => '127.0.0.1',
        //     'db_con_port' => '5432',
        //     'db_con_dbname' => 'sipedas_sync_area',
        //     'db_con_username' => 'ihsanmac',
        //     'db_con_password' => Helper::customCrypt('jankrik404'),
        // ]);
    }
}
