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
        DB::table('m_meja')->truncate();

        DB::table('m_meja')->insert([
            [
                'm_meja_nama' =>'Meja Kotak Lesehan',
                'm_meja_m_meja_jenis_id' =>5,
                'm_meja_m_w_id'=>1,
                'm_meja_type'=>'Lesehan',
                'm_meja_status_sync'=>1,
                'm_meja_created_by'=>1,
            ],
            [
                'm_meja_nama' =>'Meja Couple Kotak',
                'm_meja_m_meja_jenis_id' =>6,
                'm_meja_m_w_id'=>1,
                'm_meja_type'=>'Berdiri',
                'm_meja_status_sync'=>1,
                'm_meja_created_by'=>1,
            ],
            [
                'm_meja_nama' =>'Meja Couple Kotak',
                'm_meja_m_meja_jenis_id' =>6,
                'm_meja_m_w_id'=>5,
                'm_meja_type'=>'Berdiri',
                'm_meja_status_sync'=>1,
                'm_meja_created_by'=>1,
            ],
            [
                'm_meja_nama' =>'Meja Kotak Lesehan',
                'm_meja_m_meja_jenis_id' =>5,
                'm_meja_m_w_id'=>5,
                'm_meja_type'=>'Lesehan',
                'm_meja_status_sync'=>1,
                'm_meja_created_by'=>1,
            ],
            [
                'm_meja_nama' =>'Meja Couple Kotak',
                'm_meja_m_meja_jenis_id' =>6,
                'm_meja_m_w_id'=>8,
                'm_meja_type'=>'Berdiri',
                'm_meja_status_sync'=>1,
                'm_meja_created_by'=>1,
            ],
            [
                'm_meja_nama' =>'Meja Kotak Lesehan',
                'm_meja_m_meja_jenis_id' =>5,
                'm_meja_m_w_id'=>8,
                'm_meja_type'=>'Lesehan',
                'm_meja_status_sync'=>1,
                'm_meja_created_by'=>1,
            ],
        ]);
    }
}