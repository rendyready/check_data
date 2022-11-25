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
        DB::table('m_sub_jenis_produk')->truncate();
        DB::table('m_sub_jenis_produk')->insert([
            [
                'm_sub_jenis_produk_nama' => 'Daging',
                'm_sub_jenis_produk_m_jenis_produk_id' =>4,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Goreng',
                'm_sub_jenis_produk_m_jenis_produk_id' => 4,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Ikan',
                'm_sub_jenis_produk_m_jenis_produk_id' => 4,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Bebek',
                'm_sub_jenis_produk_m_jenis_produk_id' => 4,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Ayam',
                'm_sub_jenis_produk_m_jenis_produk_id' => 4,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Tepung',
                'm_sub_jenis_produk_m_jenis_produk_id' => 4,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Telur',
                'm_sub_jenis_produk_m_jenis_produk_id' => 4,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Bakar',
                'm_sub_jenis_produk_m_jenis_produk_id' => 4,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Sapi',
                'm_sub_jenis_produk_m_jenis_produk_id' => 4,
                'm_sub_jenis_produk_created_by' => 1,
            ],  
            [
                'm_sub_jenis_produk_nama' => 'Panas',
                'm_sub_jenis_produk_m_jenis_produk_id' => 1,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Juice',
                'm_sub_jenis_produk_m_jenis_produk_id' => 1,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Mineral',
                'm_sub_jenis_produk_m_jenis_produk_id' => 1,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Tawar',
                'm_sub_jenis_produk_m_jenis_produk_id' => 1,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Es',
                'm_sub_jenis_produk_m_jenis_produk_id' => 1,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Perkakas',
                'm_sub_jenis_produk_m_jenis_produk_id' => 12,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Buah & Sayur',
                'm_sub_jenis_produk_m_jenis_produk_id' => 12,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Bahan Dapur',
                'm_sub_jenis_produk_m_jenis_produk_id' => 12,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Frozen',
                'm_sub_jenis_produk_m_jenis_produk_id' => 12,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Mie Instan',
                'm_sub_jenis_produk_m_jenis_produk_id' => 12,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Aice',
                'm_sub_jenis_produk_m_jenis_produk_id' => 9,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Air Mineral',
                'm_sub_jenis_produk_m_jenis_produk_id' => 9,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Magnum',
                'm_sub_jenis_produk_m_jenis_produk_id' => 9,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Paddle Pop',
                'm_sub_jenis_produk_m_jenis_produk_id' => 9,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Cornetto',
                'm_sub_jenis_produk_m_jenis_produk_id' => 9,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Walls',
                'm_sub_jenis_produk_m_jenis_produk_id' => 9,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Non Menu',
                'm_sub_jenis_produk_m_jenis_produk_id' => 9,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Paket Promo',
                'm_sub_jenis_produk_m_jenis_produk_id' => 7,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Masak',
                'm_sub_jenis_produk_m_jenis_produk_id' => 3,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Sambal Lainnya',
                'm_sub_jenis_produk_m_jenis_produk_id' => 3,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Trasi',
                'm_sub_jenis_produk_m_jenis_produk_id' => 3,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Bawang',
                'm_sub_jenis_produk_m_jenis_produk_id' => 3,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Sayur Lainnya',
                'm_sub_jenis_produk_m_jenis_produk_id' => 5,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Tumis',
                'm_sub_jenis_produk_m_jenis_produk_id' => 5,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Ca',
                'm_sub_jenis_produk_m_jenis_produk_id' => 5,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Bumbu',
                'm_sub_jenis_produk_m_jenis_produk_id' => 11,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Minuman',
                'm_sub_jenis_produk_m_jenis_produk_id' => 11,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'BB Instan',
                'm_sub_jenis_produk_m_jenis_produk_id' => 11,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Suplemen',
                'm_sub_jenis_produk_m_jenis_produk_id' => 11,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Lauk Kering',
                'm_sub_jenis_produk_m_jenis_produk_id' => 11,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Cairan Pembersih',
                'm_sub_jenis_produk_m_jenis_produk_id' => 11,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Alat dan Kaos',
                'm_sub_jenis_produk_m_jenis_produk_id' => 11,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Sayuran',
                'm_sub_jenis_produk_m_jenis_produk_id' => 11,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Packing',
                'm_sub_jenis_produk_m_jenis_produk_id' => 11,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Sembako',
                'm_sub_jenis_produk_m_jenis_produk_id' => 11,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_nama' => 'Frozen Food',
                'm_sub_jenis_produk_m_jenis_produk_id' => 11,
                'm_sub_jenis_produk_created_by' => 1,
            ]
        ]);
    }
}
