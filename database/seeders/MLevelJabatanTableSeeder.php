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
                'm_level_jabatan_nama'=>'Direktur',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_nama'=>'Wakil Direktur',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_nama'=>'General Manajer',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_nama'=>'Manajer',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_nama'=>'Wakil Manajer',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_nama'=>'Kepala Saksi',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_nama'=>'Kepala Urusan',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_nama'=>'Staf Senior',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_nama'=>'Staf Khusus',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_nama'=>'Staf Manajemen',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_nama'=>'Staf Taktis',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_nama'=>'Staf Umum',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_nama'=>'Manajemen Traine',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_nama'=>'Kepala Cabang',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_nama'=>'Asisten',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_nama'=>'Wakil Asisten',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_nama'=>'Pengelola Gudang',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_nama'=>'Pengelola SDM',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_nama'=>'Koordinator Kasir',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_nama'=>'Pengelola Kulak',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_nama'=>'Patroli',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_nama'=>'Staf Waroeng',
                'm_level_jabatan_created_by'=>'1',
            ],
            [
                'm_level_jabatan_nama'=>'PUK',
                'm_level_jabatan_created_by'=>'1',
            ],
            
        ]);
    }
}