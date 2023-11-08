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
            [   'm_resep_code' => 1,
                'm_resep_m_produk_code' => "mn-400011",
                'm_resep_m_produk_nama' => "juice semangka",
                'm_resep_keterangan' =>'Semangka diblender dengan es',
                'm_resep_status'=>'Aktif',
                'm_resep_created_by'=>1
            ],  
            [
                'm_resep_code' => 1,
                'm_resep_m_produk_code' =>"mn-400023",
                'm_resep_m_produk_nama' => "coklat es",
                'm_resep_keterangan' =>'Cokles original',
                'm_resep_status'=>'Aktif',
                'm_resep_created_by'=>1
            ],
            [
                'm_resep_code' => 1,
                'm_resep_m_produk_code' =>"mn-400044",
                'm_resep_m_produk_nama' => "wedang pedas gobal gabul",
                'm_resep_keterangan' =>'Wedang gobal gabul sangat pedas',
                'm_resep_status'=>'Aktif',
                'm_resep_created_by'=>1
            ],
            [
                'm_resep_code' => 1,
                'm_resep_m_produk_code' =>"mn-400046",
                'm_resep_m_produk_nama' => "kopi hitam panas",
                'm_resep_keterangan' =>'Dengan biji kopi pilihan selera rakyat',
                'm_resep_status'=>'Aktif',
                'm_resep_created_by'=>1
            ],
            [
                'm_resep_code' => 1,
                'm_resep_m_produk_code' =>"mn-400051",
                'm_resep_m_produk_nama' => "lemon tea tawar es",
                'm_resep_keterangan' =>'lemon kualitas tingkat atas',
                'm_resep_status'=>'Aktif',
                'm_resep_created_by'=>1
            ],
        ]);
        DB::select("update m_resep set m_resep_code = id;");
    }
}