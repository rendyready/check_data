<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Http\Controllers\Controller;
class List_AktTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_link_akuntansi')->truncate();
        DB::table('m_link_akuntansi')->insert([
            [
                'm_link_akuntansi_id' => 1,
                'm_link_akuntansi_nama' =>'Pendapatan Usaha',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'',
            ], 
            [
                'm_link_akuntansi_id' => 2,
                'm_link_akuntansi_nama' =>'Biaya Produksi',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'',
            ],  
            [
                'm_link_akuntansi_id' => 3,
                'm_link_akuntansi_nama' =>'Biaya Pegawai',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'',
            ],  
            [
                'm_link_akuntansi_id' => 4,
                'm_link_akuntansi_nama' =>'Biaya Operasional',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'',
            ],  
            [
                'm_link_akuntansi_id' => 5,
                'm_link_akuntansi_nama' =>'Biaya Administrasi & Umum',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'',
            ], 
            [
                'm_link_akuntansi_id' => 6,
                'm_link_akuntansi_nama' =>'Pendapatan Lain-Lain',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'',
            ],  
            [
                'm_link_akuntansi_id' => 7,
                'm_link_akuntansi_nama' =>'Pengeluaran Lain-Lain',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'',
            ], 
            [
                'm_link_akuntansi_id' => 8,
                'm_link_akuntansi_nama' =>'Biaya Pajak',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'',
            ], 
        ]);
        }
    }

