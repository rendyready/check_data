<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class ConfigSubJenisProdukTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('config_sub_jenis_produk')->truncate();

        DB::table('config_sub_jenis_produk')->insert([
            [
                'config_sub_jenis_produk_id' =>'1',
                'config_sub_jenis_produk_m_produk_id' =>'1',
                'config_sub_jenis_produk_m_sub_jenis_produk_id'=>'29',
                'config_sub_jenis_produk_created_by'=>1,
            ],
            [
                'config_sub_jenis_produk_id' =>'2',
                'config_sub_jenis_produk_m_produk_id' =>'2',
                'config_sub_jenis_produk_m_sub_jenis_produk_id'=>'31',
                'config_sub_jenis_produk_created_by'=>1,
            ],
            [
                'config_sub_jenis_produk_id' =>'3',
                'config_sub_jenis_produk_m_produk_id' =>'3',
                'config_sub_jenis_produk_m_sub_jenis_produk_id'=>'31',
                'config_sub_jenis_produk_created_by'=>1,
            ],
            [
                'config_sub_jenis_produk_id' =>'4',
                'config_sub_jenis_produk_m_produk_id' =>'4',
                'config_sub_jenis_produk_m_sub_jenis_produk_id'=>'31',
                'config_sub_jenis_produk_created_by'=>1,
            ],
            [
                'config_sub_jenis_produk_id' =>'5',
                'config_sub_jenis_produk_m_produk_id' =>'5',
                'config_sub_jenis_produk_m_sub_jenis_produk_id'=>'31',
                'config_sub_jenis_produk_created_by'=>1,
            ],
            [
                'config_sub_jenis_produk_id' =>'6',
                'config_sub_jenis_produk_m_produk_id' =>'6',
                'config_sub_jenis_produk_m_sub_jenis_produk_id'=>'31',
                'config_sub_jenis_produk_created_by'=>1,
            ],
            [
                'config_sub_jenis_produk_id' =>'7',
                'config_sub_jenis_produk_m_produk_id' =>'7',
                'config_sub_jenis_produk_m_sub_jenis_produk_id'=>'31',
                'config_sub_jenis_produk_created_by'=>1,
            ],
            [
                'config_sub_jenis_produk_id' =>'8',
                'config_sub_jenis_produk_m_produk_id' =>'8',
                'config_sub_jenis_produk_m_sub_jenis_produk_id'=>'29',
                'config_sub_jenis_produk_created_by'=>1,
            ],
            [
                'config_sub_jenis_produk_id' =>'9',
                'config_sub_jenis_produk_m_produk_id' =>'9',
                'config_sub_jenis_produk_m_sub_jenis_produk_id'=>'29',
                'config_sub_jenis_produk_created_by'=>1,
            ],
        ]);
    }
}