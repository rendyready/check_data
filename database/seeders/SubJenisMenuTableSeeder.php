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
                'm_sub_jenis_produk_id' => '1',
                'm_sub_jenis_produk_nama' => 'daging',
                'm_sub_jenis_produk_m_jenis_produk_id' =>4,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '2',
                'm_sub_jenis_produk_nama' => 'goreng',
                'm_sub_jenis_produk_m_jenis_produk_id' => 4,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '3',
                'm_sub_jenis_produk_nama' => 'ikan',
                'm_sub_jenis_produk_m_jenis_produk_id' => 4,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '4',
                'm_sub_jenis_produk_nama' => 'bebek',
                'm_sub_jenis_produk_m_jenis_produk_id' => 4,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '5',
                'm_sub_jenis_produk_nama' => 'ayam',
                'm_sub_jenis_produk_m_jenis_produk_id' => 4,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '6',
                'm_sub_jenis_produk_nama' => 'tepung',
                'm_sub_jenis_produk_m_jenis_produk_id' => 4,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '7',
                'm_sub_jenis_produk_nama' => 'telur',
                'm_sub_jenis_produk_m_jenis_produk_id' => 4,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '8',
                'm_sub_jenis_produk_nama' => 'bakar',
                'm_sub_jenis_produk_m_jenis_produk_id' => 4,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '9',
                'm_sub_jenis_produk_nama' => 'sapi',
                'm_sub_jenis_produk_m_jenis_produk_id' => 4,
                'm_sub_jenis_produk_created_by' => 1,
            ],  
            [
                'm_sub_jenis_produk_id' => '10',
                'm_sub_jenis_produk_nama' => 'panas',
                'm_sub_jenis_produk_m_jenis_produk_id' => 1,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '11',
                'm_sub_jenis_produk_nama' => 'juice',
                'm_sub_jenis_produk_m_jenis_produk_id' => 1,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '12',
                'm_sub_jenis_produk_nama' => 'mineral',
                'm_sub_jenis_produk_m_jenis_produk_id' => 1,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '13',
                'm_sub_jenis_produk_nama' => 'tawar',
                'm_sub_jenis_produk_m_jenis_produk_id' => 1,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '14',
                'm_sub_jenis_produk_nama' => 'es',
                'm_sub_jenis_produk_m_jenis_produk_id' => 1,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '15',
                'm_sub_jenis_produk_nama' => 'perkakas',
                'm_sub_jenis_produk_m_jenis_produk_id' => 12,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '16',
                'm_sub_jenis_produk_nama' => 'buah & sayur',
                'm_sub_jenis_produk_m_jenis_produk_id' => 12,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '17',
                'm_sub_jenis_produk_nama' => 'bahan dapur',
                'm_sub_jenis_produk_m_jenis_produk_id' => 12,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '18',
                'm_sub_jenis_produk_nama' => 'frozen',
                'm_sub_jenis_produk_m_jenis_produk_id' => 12,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '19',
                'm_sub_jenis_produk_nama' => 'mie instan',
                'm_sub_jenis_produk_m_jenis_produk_id' => 12,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '20',
                'm_sub_jenis_produk_nama' => 'aice',
                'm_sub_jenis_produk_m_jenis_produk_id' => 9,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '21',
                'm_sub_jenis_produk_nama' => 'air mineral',
                'm_sub_jenis_produk_m_jenis_produk_id' => 9,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '22',
                'm_sub_jenis_produk_nama' => 'magnum',
                'm_sub_jenis_produk_m_jenis_produk_id' => 9,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '23',
                'm_sub_jenis_produk_nama' => 'paddle pop',
                'm_sub_jenis_produk_m_jenis_produk_id' => 9,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '24',
                'm_sub_jenis_produk_nama' => 'cornetto',
                'm_sub_jenis_produk_m_jenis_produk_id' => 9,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '25',
                'm_sub_jenis_produk_nama' => 'walls',
                'm_sub_jenis_produk_m_jenis_produk_id' => 9,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '26',
                'm_sub_jenis_produk_nama' => 'non menu',
                'm_sub_jenis_produk_m_jenis_produk_id' => 9,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '27',
                'm_sub_jenis_produk_nama' => 'paket promo',
                'm_sub_jenis_produk_m_jenis_produk_id' => 7,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '28',
                'm_sub_jenis_produk_nama' => 'masak',
                'm_sub_jenis_produk_m_jenis_produk_id' => 3,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '29',
                'm_sub_jenis_produk_nama' => 'sambal lainnya',
                'm_sub_jenis_produk_m_jenis_produk_id' => 3,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '30',
                'm_sub_jenis_produk_nama' => 'trasi',
                'm_sub_jenis_produk_m_jenis_produk_id' => 3,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '31',
                'm_sub_jenis_produk_nama' => 'bawang',
                'm_sub_jenis_produk_m_jenis_produk_id' => 3,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '32',
                'm_sub_jenis_produk_nama' => 'sayur lainnya',
                'm_sub_jenis_produk_m_jenis_produk_id' => 5,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '33',
                'm_sub_jenis_produk_nama' => 'tumis',
                'm_sub_jenis_produk_m_jenis_produk_id' => 5,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '34',
                'm_sub_jenis_produk_nama' => 'ca',
                'm_sub_jenis_produk_m_jenis_produk_id' => 5,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '35',
                'm_sub_jenis_produk_nama' => 'bumbu',
                'm_sub_jenis_produk_m_jenis_produk_id' => 11,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '36',
                'm_sub_jenis_produk_nama' => 'minuman',
                'm_sub_jenis_produk_m_jenis_produk_id' => 11,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '37',
                'm_sub_jenis_produk_nama' => 'bb instan',
                'm_sub_jenis_produk_m_jenis_produk_id' => 11,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '38',
                'm_sub_jenis_produk_nama' => 'suplemen',
                'm_sub_jenis_produk_m_jenis_produk_id' => 11,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '39',
                'm_sub_jenis_produk_nama' => 'lauk kering',
                'm_sub_jenis_produk_m_jenis_produk_id' => 11,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '40',
                'm_sub_jenis_produk_nama' => 'cairan pembersih',
                'm_sub_jenis_produk_m_jenis_produk_id' => 11,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '41',
                'm_sub_jenis_produk_nama' => 'alat dan kaos',
                'm_sub_jenis_produk_m_jenis_produk_id' => 11,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '42',
                'm_sub_jenis_produk_nama' => 'sayuran',
                'm_sub_jenis_produk_m_jenis_produk_id' => 11,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '43',
                'm_sub_jenis_produk_nama' => 'packing',
                'm_sub_jenis_produk_m_jenis_produk_id' => 11,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '44',
                'm_sub_jenis_produk_nama' => 'sembako',
                'm_sub_jenis_produk_m_jenis_produk_id' => 11,
                'm_sub_jenis_produk_created_by' => 1,
            ],
            [
                'm_sub_jenis_produk_id' => '45',
                'm_sub_jenis_produk_nama' => 'frozen food',
                'm_sub_jenis_produk_m_jenis_produk_id' => 11,
                'm_sub_jenis_produk_created_by' => 1,
            ]
        ]);
    }
}
