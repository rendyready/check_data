<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
class JenisMejaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_meja_jenis')->truncate();

        DB::table('m_meja_jenis')->insert([
            [
                'm_meja_jenis_nama' => 'Tenda Kecil',
                'm_meja_jenis_space' => 3,
                'm_meja_jenis_status' => 0,
                'm_meja_jenis_created_by' => 1
            ],
            [
                'm_meja_jenis_nama' => 'Tenda Bulat Besar',
                'm_meja_jenis_space' => 4,
                'm_meja_jenis_status' => 1,
                'm_meja_jenis_created_by' => 1
            ],
            [
                'm_meja_jenis_nama' => 'Tikar Lesehan',
                'm_meja_jenis_space' => 3,
                'm_meja_jenis_status' => 0,
                'm_meja_jenis_created_by' => 1
            ],
            [
                'm_meja_jenis_nama' => 'Meja Bulat Lesehan',
                'm_meja_jenis_space' => 2,
                'm_meja_jenis_status' => 0,
                'm_meja_jenis_created_by' => 1
            ],
            [
                'm_meja_jenis_nama' => 'Meja Kotak Lesehan',
                'm_meja_jenis_space' => 2,
                'm_meja_jenis_status' => 1,
                'm_meja_jenis_created_by' => 1
            ],
            [
                'm_meja_jenis_nama' => 'Meja Couple Kotak',
                'm_meja_jenis_space' => 3,
                'm_meja_jenis_status' => 0,
                'm_meja_jenis_created_by' => 1
            ],
            [
                'm_meja_jenis_nama' => 'Meja Bulat Berdiri',
                'm_meja_jenis_space' => 2,
                'm_meja_jenis_status' => 0,
                'm_meja_jenis_created_by' => 1
            ],
            [
                'm_meja_jenis_nama' => 'Meja Kotak Berdiri',
                'm_meja_jenis_space' => 4,
                'm_meja_jenis_status' => 1,
                'm_meja_jenis_created_by' => 1
            ],
            [
                'm_meja_jenis_nama' => 'Antrian',
                'm_meja_jenis_space' => 0,
                'm_meja_jenis_status' => 1,
                'm_meja_jenis_created_by' => 1
            ],
            [
                'm_meja_jenis_nama' => 'express',
                'm_meja_jenis_space' => 1,
                'm_meja_jenis_status' => 1,
                'm_meja_jenis_created_by' => 1
            ],
            [
                'm_meja_jenis_nama' => 'Bungkus',
                'm_meja_jenis_space' => 1,
                'm_meja_jenis_status' => 1,
                'm_meja_jenis_created_by' => 1
            ]
        ]);
    }
}
