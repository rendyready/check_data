<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class NmgudangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return voidm
     */
    public function run()
    {
        DB::table('m_gudang_nama')->truncate();
        DB::table('m_gudang_nama')->insert([ 
            [
                'm_gudang_nama' =>'gudang utama waroeng',
                'm_gudang_nama_created_by'=>1
            ], 
            [
                'm_gudang_nama' =>'gudang Produksi waroeng',
                'm_gudang_nama_created_by'=>1
            ],
            [
                'm_gudang_nama' =>'gudang wbd waroeng',
                'm_gudang_nama_created_by'=>1
            ],
            [
                'm_gudang_nama' =>'gudang induk supply',
                'm_gudang_nama_created_by'=>1
            ],  
        ]);
           
    }
}
