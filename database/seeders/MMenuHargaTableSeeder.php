<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class MMenuHargaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_menu_harga')->truncate();

        DB::table('m_menu_harga')->insert([
            [
                'm_menu_harga_nominal' => 3500,
                'm_menu_harga_m_jenis_nota_id' =>1,
                'm_menu_harga_m_produk_id'=>1,
                'm_menu_harga_status'=>'0',
                'm_menu_harga_created_by'=>1,
            ],
            [
                'm_menu_harga_nominal' => 2000,
                'm_menu_harga_m_jenis_nota_id' => 1,
                'm_menu_harga_m_produk_id'=>2,
                'm_menu_harga_status'=>'0',
                'm_menu_harga_created_by'=>1,
            ],
            [
                'm_menu_harga_nominal' => 2000,
                'm_menu_harga_m_jenis_nota_id' => 1,
                'm_menu_harga_m_produk_id'=>3,
                'm_menu_harga_status'=>'0',
                'm_menu_harga_created_by'=>1,
            ],
            [
                'm_menu_harga_nominal' => 2500,
                'm_menu_harga_m_jenis_nota_id' => 1,
                'm_menu_harga_m_produk_id'=>4,
                'm_menu_harga_status'=>'0',
                'm_menu_harga_created_by'=>1,
            ],
            [
                'm_menu_harga_nominal' => 2000,
                'm_menu_harga_m_jenis_nota_id' => 1,
                'm_menu_harga_m_produk_id'=>5,
                'm_menu_harga_status'=>'0',
                'm_menu_harga_created_by'=>1,
            ],
            [
                'm_menu_harga_nominal' => 2500,
                'm_menu_harga_m_jenis_nota_id' => 1,
                'm_menu_harga_m_produk_id'=>6,
                'm_menu_harga_status'=>'0',
                'm_menu_harga_created_by'=>1,
            ],
            [
                'm_menu_harga_nominal' => 2500,
                'm_menu_harga_m_jenis_nota_id' => 1,
                'm_menu_harga_m_produk_id'=>7,
                'm_menu_harga_status'=>'0',
                'm_menu_harga_created_by'=>1,
            ],
            [
                'm_menu_harga_nominal' => 2500,
                'm_menu_harga_m_jenis_nota_id' => 1,
                'm_menu_harga_m_produk_id'=>8,
                'm_menu_harga_status'=>'0',
                'm_menu_harga_created_by'=>1,
            ],
            [
                'm_menu_harga_nominal' => 6000,
                'm_menu_harga_m_jenis_nota_id' => 1,
                'm_menu_harga_m_produk_id'=>9,
                'm_menu_harga_status'=>'0',
                'm_menu_harga_created_by'=>1,
            ],
            [
                'm_menu_harga_nominal' =>3000,
                'm_menu_harga_m_jenis_nota_id' => 1,
                'm_menu_harga_m_produk_id'=>10,
                'm_menu_harga_status'=>'0',
                'm_menu_harga_created_by'=>1,
            ],
            [
                'm_menu_harga_nominal' =>2000,
                'm_menu_harga_m_jenis_nota_id' => 1,
                'm_menu_harga_m_produk_id'=>11,
                'm_menu_harga_status'=>'0',
                'm_menu_harga_created_by'=>1,
            ],
            [
                'm_menu_harga_nominal' =>5000,
                'm_menu_harga_m_jenis_nota_id' => 1,
                'm_menu_harga_m_produk_id'=>12,
                'm_menu_harga_status'=>'0',
                'm_menu_harga_created_by'=>1,
            ],
            [
                'm_menu_harga_nominal' =>5000,
                'm_menu_harga_m_jenis_nota_id' => 1,
                'm_menu_harga_m_produk_id'=>13,
                'm_menu_harga_status'=>'0',
                'm_menu_harga_created_by'=>1,
            ],
            [
                'm_menu_harga_nominal' =>3000,
                'm_menu_harga_m_jenis_nota_id' => 1,
                'm_menu_harga_m_produk_id'=>14,
                'm_menu_harga_status'=>'0',
                'm_menu_harga_created_by'=>1,
            ],
            [
                'm_menu_harga_nominal' =>3000,
                'm_menu_harga_m_jenis_nota_id' => 1,
                'm_menu_harga_m_produk_id'=>15,
                'm_menu_harga_status'=>'0',
                'm_menu_harga_created_by'=>1,
            ],
            [
                'm_menu_harga_nominal' =>3000,
                'm_menu_harga_m_jenis_nota_id' => 1,
                'm_menu_harga_m_produk_id'=>16,
                'm_menu_harga_status'=>'0',
                'm_menu_harga_created_by'=>1,
            ],
            [
                'm_menu_harga_nominal' =>2500,
                'm_menu_harga_m_jenis_nota_id' => 1,
                'm_menu_harga_m_produk_id'=>17,
                'm_menu_harga_status'=>'0',
                'm_menu_harga_created_by'=>1,
            ],
        ]);
    }
}