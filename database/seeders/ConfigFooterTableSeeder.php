<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class ConfigFooterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('config_footer')->truncate();

        DB::table('config_footer')->insert([
            [
                'config_footer_m_w_id' =>1,
                'config_footer_value'=>'Terimakasih Atas Kunjungan Anda',
                'config_footer_priority' => 1,
                'config_footer_created_by'=>1,
            ],
            [
                'config_footer_m_w_id' =>1,
                'config_footer_value'=>'Hotline SMS 0811251500',
                'config_footer_priority' => 2,
                'config_footer_created_by'=>1,
            ],
            [
                'config_footer_m_w_id' =>1,
                'config_footer_value'=>'Follow IG @waroengss',
                'config_footer_priority' => 3,
                'config_footer_created_by'=>1,
            ],
            [
                'config_footer_m_w_id' =>2,
                'config_footer_value'=>'Terimakasih Atas Kunjungan Anda',
                'config_footer_priority' => 1,
                'config_footer_created_by'=>1,
            ],
            [
                'config_footer_m_w_id' =>2,
                'config_footer_value'=>'Hotline SMS 0811251500',
                'config_footer_priority' => 2,
                'config_footer_created_by'=>1,
            ],
            [
                'config_footer_m_w_id' =>2,
                'config_footer_value'=>'Follow IG @waroengss',
                'config_footer_priority' => 3,
                'config_footer_created_by'=>1,
            ],
        ]);
    }
}