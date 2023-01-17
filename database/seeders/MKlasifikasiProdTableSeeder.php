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
                'm_klasifikasi_produk_nama' =>'BBTL',
                'm_klasifikasi_produk_created_by' =>1
            ],
            [
                'm_klasifikasi_produk_nama' =>'BBOPS',
                'm_klasifikasi_produk_created_by' =>1
            ],
            [
                'm_klasifikasi_produk_nama' =>'BB Utama',
                'm_klasifikasi_produk_created_by' =>1
            ],
            [
                'm_klasifikasi_produk_nama' =>'Jadi',
                'm_klasifikasi_produk_created_by' =>1
            ],
        ]);
    }
}