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
                'm_w_jenis_id' => '1',
                'm_w_jenis_nama' => 'waroeng area',
                'm_w_jenis_created_by' => 1
            ],
            [
                'm_w_jenis_id' => '2',
                'm_w_jenis_nama' => 'waroeng mandiri',
                'm_w_jenis_created_by' => 1
            ],
            [
                'm_w_jenis_id' => '3',
                'm_w_jenis_nama' => 'waroeng khusus',
                'm_w_jenis_created_by' => 1
            ],
            [
                'm_w_jenis_id' => '4',
                'm_w_jenis_nama' => 'kantor pusat',
                'm_w_jenis_created_by' => 1
            ],
            [
                'm_w_jenis_id' => '5',
                'm_w_jenis_nama' => 'kantor area',
                'm_w_jenis_created_by' => 1
            ],
            [
                'm_w_jenis_id' => '6',
                'm_w_jenis_nama' => 'dapur area',
                'm_w_jenis_created_by' => 1
            ]
        ]);
    }
}
