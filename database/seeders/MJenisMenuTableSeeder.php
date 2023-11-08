<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class MJenisMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_jenis_produk')->truncate();

        DB::table('m_jenis_produk')->insert([
            [
                'm_jenis_produk_id' => '1',
                'm_jenis_produk_nama' => 'minuman',
                'm_jenis_produk_odcr55' => 'minum',
                'm_jenis_produk_created_by' => 1,
                'm_jenis_produk_urut' => 1
            ],
            [
                'm_jenis_produk_id' => '2',
                'm_jenis_produk_nama' => 'buah',
                'm_jenis_produk_odcr55' => 'minum',
                'm_jenis_produk_created_by' => 1,
                'm_jenis_produk_urut' => 2
            ],
            [
                'm_jenis_produk_id' => '3',
                'm_jenis_produk_nama' => 'sambal',
                'm_jenis_produk_odcr55' => 'makan',
                'm_jenis_produk_created_by' => 1,
                'm_jenis_produk_urut' => 3
            ],
            [
                'm_jenis_produk_id' => '4',
                'm_jenis_produk_nama' => 'lauk',
                'm_jenis_produk_odcr55' => 'makan',
                'm_jenis_produk_created_by' => 1,
                'm_jenis_produk_urut' => 4
            ],
            [
                'm_jenis_produk_id' => '5',
                'm_jenis_produk_nama' => 'sayur',
                'm_jenis_produk_odcr55' => 'makan',
                'm_jenis_produk_created_by' => 1,
                'm_jenis_produk_urut' => 5
            ],
            [
                'm_jenis_produk_id' => '6',
                'm_jenis_produk_nama' => 'nasi',
                'm_jenis_produk_odcr55' => 'makan',
                'm_jenis_produk_created_by' => 1,
                'm_jenis_produk_urut' => 6
            ],
            [
                'm_jenis_produk_id' => '7',
                'm_jenis_produk_nama' => 'paket',
                'm_jenis_produk_odcr55' => 'makan',
                'm_jenis_produk_created_by' => 1,
                'm_jenis_produk_urut' => 7
            ],
            [
                'm_jenis_produk_id' => '8',
                'm_jenis_produk_nama' => 'lain-lain',
                'm_jenis_produk_odcr55' => null,
                'm_jenis_produk_created_by' => 1,
                'm_jenis_produk_urut' => 8
            ],
            [
                'm_jenis_produk_id' => '9',
                'm_jenis_produk_nama' => 'non-menu',
                'm_jenis_produk_odcr55' => 'minum',
                'm_jenis_produk_created_by' => 1,
                'm_jenis_produk_urut' => 9
            ],  
            [
                'm_jenis_produk_id' => '10',
                'm_jenis_produk_nama' => 'promo',
                'm_jenis_produk_odcr55' => 'makan',
                'm_jenis_produk_created_by' => 1,
                'm_jenis_produk_urut' => 10
            ],
            [
                'm_jenis_produk_id' => '11',
                'm_jenis_produk_nama' => 'wbd-corner',
                'm_jenis_produk_odcr55' => 'makan',
                'm_jenis_produk_created_by' => 1,
                'm_jenis_produk_urut' => 11
            ],
            [
                'm_jenis_produk_id' => '12',
                'm_jenis_produk_nama' => 'mutasi-wbd',
                'm_jenis_produk_odcr55' => 'makan',
                'm_jenis_produk_created_by' => 1,
                'm_jenis_produk_urut' => 12
            ],
            [
                'm_jenis_produk_id' => '13',
                'm_jenis_produk_nama' => 'bb',
                'm_jenis_produk_odcr55' => 'makan',
                'm_jenis_produk_created_by' => 1,
                'm_jenis_produk_urut' => 13
            ]
          
         
        ]);
    }
}
