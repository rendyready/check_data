<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class ConfigMejaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('config_meja')->truncate();

        DB::table('config_meja')->insert([
            [
                'config_meja_nama' =>'Meja Kotak Lesehan',
                'config_meja_m_meja_jenis_id' =>5,
                'config_meja_m_w_id'=>1,
                'config_meja_type'=>'Lesehan',
                'config_meja_status_sync'=>1,
                'config_meja_created_by'=>1,
            ],
            [
                'config_meja_nama' =>'Meja Couple Kotak',
                'config_meja_m_meja_jenis_id' =>6,
                'config_meja_m_w_id'=>1,
                'config_meja_type'=>'Berdiri',
                'config_meja_status_sync'=>1,
                'config_meja_created_by'=>1,
            ],
            [
                'config_meja_nama' =>'Meja Couple Kotak',
                'config_meja_m_meja_jenis_id' =>6,
                'config_meja_m_w_id'=>5,
                'config_meja_type'=>'Berdiri',
                'config_meja_status_sync'=>1,
                'config_meja_created_by'=>1,
            ],
            [
                'config_meja_nama' =>'Meja Kotak Lesehan',
                'config_meja_m_meja_jenis_id' =>5,
                'config_meja_m_w_id'=>5,
                'config_meja_type'=>'Lesehan',
                'config_meja_status_sync'=>1,
                'config_meja_created_by'=>1,
            ],
            [
                'config_meja_nama' =>'Meja Couple Kotak',
                'config_meja_m_meja_jenis_id' =>6,
                'config_meja_m_w_id'=>8,
                'config_meja_type'=>'Berdiri',
                'config_meja_status_sync'=>1,
                'config_meja_created_by'=>1,
            ],
            [
                'config_meja_nama' =>'Meja Kotak Lesehan',
                'config_meja_m_meja_jenis_id' =>5,
                'config_meja_m_w_id'=>8,
                'config_meja_type'=>'Lesehan',
                'config_meja_status_sync'=>1,
                'config_meja_created_by'=>1,
            ],
        ]);
    }
}