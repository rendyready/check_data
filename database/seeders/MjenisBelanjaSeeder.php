<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
class MjenisBelanjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_jenis_belanja')->insert([
            [
                'm_jenis_belanja_id' => '1',
                'm_jenis_belanja_nama' => 'belanja harian',
                'm_jenis_belanja_created_by' => 1,
                'm_jenis_belanja_created_at' => Carbon::now(),
            ],
            [
                'm_jenis_belanja_id' => '2',
                'm_jenis_belanja_nama' => 'belanja 3 harian',
                'm_jenis_belanja_created_by' => 1,
                'm_jenis_belanja_created_at' => Carbon::now(),
            ],
            [
                'm_jenis_belanja_id' => '3',
                'm_jenis_belanja_nama' => 'belanja mingguan',
                'm_jenis_belanja_created_by' => 1,
                'm_jenis_belanja_created_at' => Carbon::now(),
            ],
            [
                'm_jenis_belanja_id' => '4',
                'm_jenis_belanja_nama' => 'belanja ecer',
                'm_jenis_belanja_created_by' => 1,
                'm_jenis_belanja_created_at' => Carbon::now(),
            ],
        ]);
    }
}
