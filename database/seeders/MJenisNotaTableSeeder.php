<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class MJenisNotaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_jenis_nota')->truncate();
        DB::table('m_menu_harga')->truncate();
        // for ($i=1; $i <= 7 ; $i++) { 
        //     DB::table('m_jenis_nota')->insert([
        //         [
        //             'm_jenis_nota_id' => $i,
        //             'm_jenis_nota_m_w_id' => '1',
        //             'm_jenis_nota_m_t_t_id' => "{$i}",
        //             'm_jenis_nota_created_by' => 1
        //         ]
        //     ]);
        // }
    }
}
