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
        DB::table('m_footer')->truncate();

        DB::table('m_footer')->insert([
            [
                'm_footer_id' =>'1',
                'm_footer_m_w_id' =>1,
                'm_footer_value'=>'Terimakasih Atas Kunjungan Anda',
                'm_footer_priority' => 1,
                'm_footer_created_by'=>1,
            ],
            [
                'm_footer_id' =>'2',
                'm_footer_m_w_id' =>1,
                'm_footer_value'=>'Hotline SMS 0811251500',
                'm_footer_priority' => 2,
                'm_footer_created_by'=>1,
            ],
            [
                'm_footer_id' =>'3',
                'm_footer_m_w_id' =>1,
                'm_footer_value'=>'Follow IG @waroengss',
                'm_footer_priority' => 3,
                'm_footer_created_by'=>1,
            ],
            [
                'm_footer_id' =>'4',
                'm_footer_m_w_id' =>2,
                'm_footer_value'=>'Terimakasih Atas Kunjungan Anda',
                'm_footer_priority' => 1,
                'm_footer_created_by'=>1,
            ],
            [
                'm_footer_id' =>'5',
                'm_footer_m_w_id' =>2,
                'm_footer_value'=>'Hotline SMS 0811251500',
                'm_footer_priority' => 2,
                'm_footer_created_by'=>1,
            ],
            [
                'm_footer_id' =>'6',
                'm_footer_m_w_id' =>2,
                'm_footer_value'=>'Follow IG @waroengss',
                'm_footer_priority' => 3,
                'm_footer_created_by'=>1,
            ],
        ]);
    }
}