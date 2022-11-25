<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class MResepDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_resep_detail')->truncate();

        DB::table('m_resep_detail')->insert([
            [
                'm_resep_detail_m_resep_id' =>1,
                'm_resep_detail_bb_id'=>1,
                'm_resep_detail_bb_qty'=>2,
                'm_resep_detail_m_satuan_id'=>3,
                'm_resep_detail_created_by'=>1,
            ],
            [
                'm_resep_detail_m_resep_id' =>13,
                'm_resep_detail_bb_id'=>13,
                'm_resep_detail_bb_qty'=>2,
                'm_resep_detail_m_satuan_id'=>3,
                'm_resep_detail_created_by'=>1,
            ],
            [
                'm_resep_detail_m_resep_id' =>21,
                'm_resep_detail_bb_id'=>21,
                'm_resep_detail_bb_qty'=>2,
                'm_resep_detail_m_satuan_id'=>3,
                'm_resep_detail_created_by'=>1,
            ],
            [
                'm_resep_detail_m_resep_id' =>31,
                'm_resep_detail_bb_id'=>31,
                'm_resep_detail_bb_qty'=>20,
                'm_resep_detail_m_satuan_id'=>3,
                'm_resep_detail_created_by'=>1,
            ],
            [
                'm_resep_detail_m_resep_id' =>32,
                'm_resep_detail_bb_id'=>32,
                'm_resep_detail_bb_qty'=>11,
                'm_resep_detail_m_satuan_id'=>1,
                'm_resep_detail_created_by'=>1,
            ],
        ]);
    }
}