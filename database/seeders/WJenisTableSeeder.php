<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class WJenisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_w_jenis')->truncate();

        DB::table('m_w_jenis')->insert([
            [
                'm_w_jenis_nama' => 'Waroeng Area',
                'm_w_jenis_created_by' => 1
            ],
            [
                'm_w_jenis_nama' => 'Waroeng Mandiri',
                'm_w_jenis_created_by' => 1
            ],
            [
                'm_w_jenis_nama' => 'Waroeng Khusus',
                'm_w_jenis_created_by' => 1
            ],
            [
                'm_w_jenis_nama' => 'Kantor Pusat',
                'm_w_jenis_created_by' => 1
            ],
            [
                'm_w_jenis_nama' => 'Kantor Area',
                'm_w_jenis_created_by' => 1
            ],
            [
                'm_w_jenis_nama' => 'Dapur Area',
                'm_w_jenis_created_by' => 1
            ]
        ]);
    }
}
