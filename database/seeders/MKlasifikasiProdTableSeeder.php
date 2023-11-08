<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class MKlasifikasiProdTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_klasifikasi_produk')->truncate();

        DB::table('m_klasifikasi_produk')->insert([
            [
                'm_klasifikasi_produk_id' =>'1',
                'm_klasifikasi_produk_nama' =>'BB Tidak Langsung',
                'm_klasifikasi_produk_prefix' => 'tl',
                'm_klasifikasi_produk_last_id' => 59,
                'm_klasifikasi_produk_created_by' =>1
            ],
            [
                'm_klasifikasi_produk_id' =>'2',
                'm_klasifikasi_produk_nama' =>'BB Operasional',
                'm_klasifikasi_produk_prefix' => 'bo',
                'm_klasifikasi_produk_last_id' => 30,
                'm_klasifikasi_produk_created_by' =>1
            ],
            [
                'm_klasifikasi_produk_id' =>'3',
                'm_klasifikasi_produk_nama' =>'Bahan Baku',
                'm_klasifikasi_produk_prefix' => 'bb',
                'm_klasifikasi_produk_last_id' => 292,
                'm_klasifikasi_produk_created_by' =>1
            ],
            [
                'm_klasifikasi_produk_id' =>'4',
                'm_klasifikasi_produk_nama' =>'Menu',
                'm_klasifikasi_produk_prefix' => 'mn',
                'm_klasifikasi_produk_last_id' => 451,
                'm_klasifikasi_produk_created_by' =>1
            ],
        ]);
    }
}