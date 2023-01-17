<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class NmGudangTableSeeder extends Seeder
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
                'm_gudang_nama' =>'Gudang Utama Wareong',
                'm_gudang_nama_created_by'=>1
            ], 
            [
                'm_gudang_nama' =>'Gudang Produksi Waroeng',
                'm_gudang_nama_created_by'=>1
            ],
            [
                'm_gudang_nama' =>'Gudang WBD Waroeng',
                'm_gudang_nama_created_by'=>1
            ],
            [
                'm_gudang_nama' =>'Gudang Induk Supply',
                'm_gudang_nama_created_by'=>1
            ],  
        ]);
           
    }
}
