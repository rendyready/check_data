<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ProdukCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_produk_code')->insert([
            'm_produk_code_bb' => '300000',
            'm_produk_code_bo' => '200000',
            'm_produk_code_tl' => '100000',
            'm_produk_code_mn' => '400000',
        ]);
    }
}
