<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class MResepTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_resep')->truncate();

        DB::table('m_resep')->insert([
            [   'm_resep_id' => 1,
                'm_resep_m_produk_id' => 383,
                'm_resep_keterangan' =>'Bawang merah,bawah putih,trasi udang,dan cabe pilihan',
                'm_resep_status'=>'Aktif',
                'm_resep_created_by'=>1
            ],  
            [
                'm_resep_id' => 1,
                'm_resep_m_produk_id' =>385,
                'm_resep_keterangan' =>'Sambal Trasi ditambahkan belut goreng krispy',
                'm_resep_status'=>'Aktif',
                'm_resep_created_by'=>1
            ],
            [
                'm_resep_id' => 1,
                'm_resep_m_produk_id' =>490,
                'm_resep_keterangan' =>'Ayam fresh dipotong dan dimasak dengan bumbu sangat pedas',
                'm_resep_status'=>'Aktif',
                'm_resep_created_by'=>1
            ],
            [
                'm_resep_id' => 1,
                'm_resep_m_produk_id' =>500,
                'm_resep_keterangan' =>'Ayam kampung fresh yang telah dimarinasi dengan bumbu rahasia',
                'm_resep_status'=>'Aktif',
                'm_resep_created_by'=>1
            ],
            [
                'm_resep_id' => 1,
                'm_resep_m_produk_id' =>525,
                'm_resep_keterangan' =>'Ikan bandeng fresh yang telah dimarinasi dengan bumbu rahasia',
                'm_resep_status'=>'Aktif',
                'm_resep_created_by'=>1
            ],
        ]);
        DB::select("update m_resep set m_resep_id = id;");
    }
}