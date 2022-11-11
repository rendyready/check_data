<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SubJenisMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_sub_menu_jenis')->truncate();
        DB::table('m_sub_menu_jenis')->insert([
            [
                'm_sub_menu_jenis_nama' => 'Daging',
                'm_sub_menu_jenis_m_menu_jenis_id' =>4,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Goreng',
                'm_sub_menu_jenis_m_menu_jenis_id' => 4,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Ikan',
                'm_sub_menu_jenis_m_menu_jenis_id' => 4,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Bebek',
                'm_sub_menu_jenis_m_menu_jenis_id' => 4,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Ayam',
                'm_sub_menu_jenis_m_menu_jenis_id' => 4,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Tepung',
                'm_sub_menu_jenis_m_menu_jenis_id' => 4,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Telur',
                'm_sub_menu_jenis_m_menu_jenis_id' => 4,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Bakar',
                'm_sub_menu_jenis_m_menu_jenis_id' => 4,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Sapi',
                'm_sub_menu_jenis_m_menu_jenis_id' => 4,
                'm_sub_menu_jenis_created_by' => 1,
            ],  
            [
                'm_sub_menu_jenis_nama' => 'Panas',
                'm_sub_menu_jenis_m_menu_jenis_id' => 1,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Juice',
                'm_sub_menu_jenis_m_menu_jenis_id' => 1,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Mineral',
                'm_sub_menu_jenis_m_menu_jenis_id' => 1,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Tawar',
                'm_sub_menu_jenis_m_menu_jenis_id' => 1,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Es',
                'm_sub_menu_jenis_m_menu_jenis_id' => 1,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Perkakas',
                'm_sub_menu_jenis_m_menu_jenis_id' => 12,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Buah & Sayur',
                'm_sub_menu_jenis_m_menu_jenis_id' => 12,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Bahan Dapur',
                'm_sub_menu_jenis_m_menu_jenis_id' => 12,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Frozen',
                'm_sub_menu_jenis_m_menu_jenis_id' => 12,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Mie Instan',
                'm_sub_menu_jenis_m_menu_jenis_id' => 12,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Aice',
                'm_sub_menu_jenis_m_menu_jenis_id' => 9,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Air Mineral',
                'm_sub_menu_jenis_m_menu_jenis_id' => 9,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Magnum',
                'm_sub_menu_jenis_m_menu_jenis_id' => 9,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Paddle Pop',
                'm_sub_menu_jenis_m_menu_jenis_id' => 9,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Cornetto',
                'm_sub_menu_jenis_m_menu_jenis_id' => 9,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Walls',
                'm_sub_menu_jenis_m_menu_jenis_id' => 9,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Non Menu',
                'm_sub_menu_jenis_m_menu_jenis_id' => 9,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Paket Promo',
                'm_sub_menu_jenis_m_menu_jenis_id' => 7,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Masak',
                'm_sub_menu_jenis_m_menu_jenis_id' => 3,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Sambal Lainnya',
                'm_sub_menu_jenis_m_menu_jenis_id' => 3,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Trasi',
                'm_sub_menu_jenis_m_menu_jenis_id' => 3,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Bawang',
                'm_sub_menu_jenis_m_menu_jenis_id' => 3,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Sayur Lainnya',
                'm_sub_menu_jenis_m_menu_jenis_id' => 5,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Tumis',
                'm_sub_menu_jenis_m_menu_jenis_id' => 5,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Ca',
                'm_sub_menu_jenis_m_menu_jenis_id' => 5,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Bumbu',
                'm_sub_menu_jenis_m_menu_jenis_id' => 11,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Minuman',
                'm_sub_menu_jenis_m_menu_jenis_id' => 11,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'BB Instan',
                'm_sub_menu_jenis_m_menu_jenis_id' => 11,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Suplemen',
                'm_sub_menu_jenis_m_menu_jenis_id' => 11,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Lauk Kering',
                'm_sub_menu_jenis_m_menu_jenis_id' => 11,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Cairan Pembersih',
                'm_sub_menu_jenis_m_menu_jenis_id' => 11,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Alat dan Kaos',
                'm_sub_menu_jenis_m_menu_jenis_id' => 11,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Sayuran',
                'm_sub_menu_jenis_m_menu_jenis_id' => 11,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Packing',
                'm_sub_menu_jenis_m_menu_jenis_id' => 11,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Sembako',
                'm_sub_menu_jenis_m_menu_jenis_id' => 11,
                'm_sub_menu_jenis_created_by' => 1,
            ],
            [
                'm_sub_menu_jenis_nama' => 'Frozen Food',
                'm_sub_menu_jenis_m_menu_jenis_id' => 11,
                'm_sub_menu_jenis_created_by' => 1,
            ]
        ]);
    }
}
