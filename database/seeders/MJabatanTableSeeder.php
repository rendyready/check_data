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
                'm_jabatan_m_level_jabatan_id'=>'1',
                'm_jabatan_nama'=>'Direktur',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'2',
                'm_jabatan_nama'=>'Wakil Direktur',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'3',
                'm_jabatan_nama'=>'GM Operasi',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'4',
                'm_jabatan_nama'=>'Manajer Area',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'4',
                'm_jabatan_nama'=>'Manajer Operasi Pusat',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'5',
                'm_jabatan_nama'=>'Wakil Manajer',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'6',
                'm_jabatan_nama'=>'Kepala Seksi Operasi Pusat',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'6',
                'm_jabatan_nama'=>'Kepala Seksi Operasi Area',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'7',
                'm_jabatan_nama'=>'Kepala Urusan Operasi Pusat',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'7',
                'm_jabatan_nama'=>'Kepala Urusan Operasi Area',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'8',
                'm_jabatan_nama'=>'Staf Senior Operasi Pusat',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'8',
                'm_jabatan_nama'=>'Staf Senior Operasi Area',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'10',
                'm_jabatan_nama'=>'Staf Manajemen Operasi Pusat',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'10',
                'm_jabatan_nama'=>'Staf Manajemen Operasi Area',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'3',
                'm_jabatan_nama'=>'GM Support',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'3',
                'm_jabatan_nama'=>'GM Keuangan',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'4',
                'm_jabatan_nama'=>'Manajer IT',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'4',
                'm_jabatan_nama'=>'Manajer SDM Pusat',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'4',
                'm_jabatan_nama'=>'Manajer Keuangan & Pajak Pusat',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'6',
                'm_jabatan_nama'=>'Kepala Seksi SDM Area',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'6',
                'm_jabatan_nama'=>'Kepala Seksi Rekrutmen dan Training Pusat',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'6',
                'm_jabatan_nama'=>'Kepala Seksi Auditor Pusat',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'14',
                'm_jabatan_nama'=>'Kepala Cabang',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'15',
                'm_jabatan_nama'=>'Asisten Produksi',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'15',
                'm_jabatan_nama'=>'Asisten PGD',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'15',
                'm_jabatan_nama'=>'Asisten Keuangan',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'17',
                'm_jabatan_nama'=>'Pengelola Gudang',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'19',
                'm_jabatan_nama'=>'Koordinator Kasir',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'23',
                'm_jabatan_nama'=>'PUK',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
            [
                'm_jabatan_m_level_jabatan_id'=>'13',
                'm_jabatan_nama'=>'Manajemen Trainee',
                'm_jabatan_parent_id'=>Null,
                'm_jabatan_created_by'=>'1',
            ],
        ]);
    }
}