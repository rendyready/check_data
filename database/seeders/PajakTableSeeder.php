<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class PajakTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_pajak')->truncate();

        DB::table('m_pajak')->insert([
            'm_pajak_value' => 0.0,
            'm_pajak_created_by'=> 1,
            
        ]);

        DB::table('m_pajak')->insert([
            'm_pajak_value' => 0.10,
            'm_pajak_created_by'=> 1,
            
        ]);

        DB::table('m_pajak')->insert([
            'm_pajak_value' => 0.11,
            'm_pajak_created_by'=> 1,
            
        ]);

        DB::table('m_pajak')->insert([
            'm_pajak_value' => 0.12,
            'm_pajak_created_by'=> 1,
            
        ]);
        // foreach ($pajak as $key => $value) {
        //     DB::table('m_pajak')->insert([
        //         'm_pajak_value' => $value,
        //         'm_pajak_created_by'=> 1,
        //     ]);
        // }
    }
}
