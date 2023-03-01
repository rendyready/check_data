<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class MLevelJabatanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_level_jabatan')->truncate();

        DB::table('m_level_jabatan')->insert([
            [
                'm_level_jabatan_id'=>'MLJ112303011',
                'm_level_jabatan_nama'=>'Direktur',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_id'=>'MLJ112303012',
                'm_level_jabatan_nama'=>'Wakil Direktur',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_id'=>'MLJ112303013',
                'm_level_jabatan_nama'=>'General Manajer',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_id'=>'MLJ112303014',
                'm_level_jabatan_nama'=>'Manajer',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_id'=>'MLJ112303015',
                'm_level_jabatan_nama'=>'Wakil Manajer',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_id'=>'MLJ112303016',
                'm_level_jabatan_nama'=>'Kepala Saksi',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_id'=>'MLJ112303017',
                'm_level_jabatan_nama'=>'Kepala Urusan',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_id'=>'MLJ112303018',
                'm_level_jabatan_nama'=>'Staf Senior',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_id'=>'MLJ112303019',
                'm_level_jabatan_nama'=>'Staf Khusus',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_id'=>'MLJ1123030110',
                'm_level_jabatan_nama'=>'Staf Manajemen',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_id'=>'MLJ1123030111',
                'm_level_jabatan_nama'=>'Staf Taktis',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_id'=>'MLJ1123030112',
                'm_level_jabatan_nama'=>'Staf Umum',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_id'=>'MLJ1123030113',
                'm_level_jabatan_nama'=>'Manajemen Traine',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_id'=>'MLJ1123030114',
                'm_level_jabatan_nama'=>'Kepala Cabang',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_id'=>'MLJ1123030115',
                'm_level_jabatan_nama'=>'Asisten',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_id'=>'MLJ1123030116',
                'm_level_jabatan_nama'=>'Wakil Asisten',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_id'=>'MLJ1123030117',
                'm_level_jabatan_nama'=>'Staf Waroeng',
                'm_level_jabatan_created_by'=>'1',
            ]
        ]);
    }
}