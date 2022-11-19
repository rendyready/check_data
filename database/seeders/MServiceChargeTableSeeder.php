<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class MServiceChargeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_sc')->truncate();

        DB::table('m_sc')->insert([
            [
                'm_sc_value' => 0.00,
                'm_sc_created_by' => 1
            ],
            [
                'm_sc_value' => 0.05,
                'm_sc_created_by' => 1
            ],
            [
                'm_sc_value' => 0.03,
                'm_sc_created_by' => 1
            ], 
        ]);
    }
}