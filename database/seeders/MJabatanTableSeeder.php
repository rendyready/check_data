<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class MJabatanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_jabatan')->truncate();

        DB::table('m_jabatan')->insert([
            [
                'm_jabatan_id'=>'MJ112303011',
                'm_jabatan_m_level_jabatan_id'=>'MLJ112303011',
                'm_jabatan_nama'=>'Direktur',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_id'=>'MJ112303012',
                'm_jabatan_m_level_jabatan_id'=>'MLJ112303012',
                'm_jabatan_nama'=>'Wakil Direktur',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_id'=>'MJ112303013',
                'm_jabatan_m_level_jabatan_id'=>'MLJ112303013',
                'm_jabatan_nama'=>'GM Operasi',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_id'=>'MJ112303014',
                'm_jabatan_m_level_jabatan_id'=>'MLJ112303013',
                'm_jabatan_nama'=>'GM Support',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_id'=>'MJ112303015',
                'm_jabatan_m_level_jabatan_id'=>'MLJ112303013',
                'm_jabatan_nama'=>'GM Keuangan',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_id'=>'MJ112303016',
                'm_jabatan_m_level_jabatan_id'=>'MLJ112303014',
                'm_jabatan_nama'=>'Manajer Operasi',
                'm_jabatan_parent_id'=>'MJ112303013',
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_id'=>'MJ112303017',
                'm_jabatan_m_level_jabatan_id'=>'MLJ112303014',
                'm_jabatan_nama'=>'Manajer Internal Audit',
                'm_jabatan_parent_id'=>'MJ112303013',
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_id'=>'MJ112303018',
                'm_jabatan_m_level_jabatan_id'=>'MLJ112303014',
                'm_jabatan_nama'=>'Manajer SDM',
                'm_jabatan_parent_id'=>'MJ112303014',
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_id'=>'MJ112303019',
                'm_jabatan_m_level_jabatan_id'=>'MLJ112303014',
                'm_jabatan_nama'=>'Manager RTEO',
                'm_jabatan_parent_id'=>'MJ112303014',
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_id'=>'MJ1123030110',
                'm_jabatan_m_level_jabatan_id'=>'MLJ112303014',
                'm_jabatan_nama'=>'Manajer IT',
                'm_jabatan_parent_id'=>'MJ112303014',
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_id'=>'MJ1123030111',
                'm_jabatan_m_level_jabatan_id'=>'MLJ112303014',
                'm_jabatan_nama'=>'Manajer PO',
                'm_jabatan_parent_id'=>'MJ112303014',
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_id'=>'MJ1123030112',
                'm_jabatan_m_level_jabatan_id'=>'MLJ112303014',
                'm_jabatan_nama'=>'Manajer Akuntansi',
                'm_jabatan_parent_id'=>'MJ112303015',
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_id'=>'MJ1123030113',
                'm_jabatan_m_level_jabatan_id'=>'MLJ112303014',
                'm_jabatan_nama'=>'Manajer Keuangan',
                'm_jabatan_parent_id'=>'MJ112303015',
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_id'=>'MJ1123030114',
                'm_jabatan_m_level_jabatan_id'=>'MLJ112303014',
                'm_jabatan_nama'=>'Manajer Area',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            
        ]);
    }
}