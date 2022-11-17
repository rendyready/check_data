<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class WaroengJenisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_w_jenis')->truncate();
        $warjenis = ['Area','Mandiri'];

        foreach ($warjenis as $key => $value) {
            DB::table('m_w_jenis')->insert([
                'm_w_jenis_nama' => $value,
                'm_w_jenis_created_by'=> 1,
            ]);
        }
    }
}
