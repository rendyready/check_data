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
                'm_link_akuntansi_nama' =>'Kas',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'01.01.01',
            ], 
            [
                'm_link_akuntansi_id' => 2,
                'm_link_akuntansi_nama' =>'Penjualan',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'02.01.01',
            ],  
            [
                'm_link_akuntansi_id' => 3,
                'm_link_akuntansi_nama' =>'Hutang Pajak',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'03.01.01',
            ],  
            [
                'm_link_akuntansi_id' => 4,
                'm_link_akuntansi_nama' =>'Biaya Service Charge',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'05.01.01',
            ],  
            [
                'm_link_akuntansi_id' => 5,
                'm_link_akuntansi_nama' =>'Hutang Profit Out',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'04.01.01',
            ], 
            [
                'm_link_akuntansi_id' => 6,
                'm_link_akuntansi_nama' =>'Biaya Diskon',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'07.01.01',
            ],  
            [
                'm_link_akuntansi_id' => 7,
                'm_link_akuntansi_nama' =>'Biaya Pembulatan',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'08.01.01',
            ], 
            [
                'm_link_akuntansi_id' => 8,
                'm_link_akuntansi_nama' =>'Biaya Tarik Tunai',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'09.01.01',
            ], 
            [
                'm_link_akuntansi_id' => 9,
                'm_link_akuntansi_nama' =>'Biaya Free Kembalian',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'10.01.01',
            ],
            [
                'm_link_akuntansi_id' => 10,
                'm_link_akuntansi_nama' =>'Biaya Lost bill',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'11.01.01',
            ],
            [
                'm_link_akuntansi_id' => 11,
                'm_link_akuntansi_nama' =>'Biaya Pajak lostbill',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'12.01.01',
            ],
            [
                'm_link_akuntansi_id' => 12,
                'm_link_akuntansi_nama' =>'Biaya service Charge lost bill',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'05.01.02',
            ],
            [
                'm_link_akuntansi_id' => 13,
                'm_link_akuntansi_nama' =>'Biaya garansi',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'13.01.01',
            ],
            [
                'm_link_akuntansi_id' => 14,
                'm_link_akuntansi_nama' =>'Biaya refund',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'14.01.01',
            ],
            [
                'm_link_akuntansi_id' => 15,
                'm_link_akuntansi_nama' =>'biaya pajak refund',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'15.01.01',
            ],
            [
                'm_link_akuntansi_id' => 16,
                'm_link_akuntansi_nama' =>'biaya service charge refund',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'05.01.03',
            ],
            [
                'm_link_akuntansi_id' => 17,
                'm_link_akuntansi_nama' =>'biaya pembulatan refund',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'08.01.02',
            ],
            [
                'm_link_akuntansi_id' => 18,
                'm_link_akuntansi_nama' =>'biaya free kembalian refund',
                'm_link_akuntansi_created_by'=>1,
                'm_link_akuntansi_m_rekening_id'=>'10.01.02',
            ],
        ]);
        }
    }

