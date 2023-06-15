<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class MRekeningTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_rekening')->truncate();

        DB::table('m_rekening')->insert([
            [
                'm_rekening_id' => 1,
                'm_rekening_m_waroeng_id'=> '001',
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'01.01.01',
                'm_rekening_nama'=>'kas',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 2,
            ],
            [
                'm_rekening_id' => 2,
                'm_rekening_m_waroeng_id'=> '001',
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'01.02.01',
                'm_rekening_nama'=>'bank',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 2,
            ],
            [
                'm_rekening_id' => 3,
                'm_rekening_m_waroeng_id'=> '001',
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'01.11.01',
                'm_rekening_nama'=>'penjualan menu',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 2,
            ],
            [
                'm_rekening_id' => 4,
                'm_rekening_m_waroeng_id'=> '001',
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'01.12.01',
                'm_rekening_nama'=>'biaya bahan baku',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 2,
            ],
            [
                'm_rekening_id' => 5,
                'm_rekening_m_waroeng_id'=> '001',
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'02.02.01',
                'm_rekening_nama'=>'biaya bb operasional',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 2,
            ],
            [
                'm_rekening_id' => 6,
                'm_rekening_m_waroeng_id'=> '001',
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'04.01.01',
                'm_rekening_nama'=>'biaya peralatan operasional',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 2,
            ],
            [
                'm_rekening_id' => 7,
                'm_rekening_m_waroeng_id'=> '001',
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'04.02.01',
                'm_rekening_nama'=>'biaya peralatan produksi',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 2,
            ],
            [
                'm_rekening_id' => 8,
                'm_rekening_m_waroeng_id'=> '001',
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'05.01.01',
                'm_rekening_nama'=>'biaya pemeliharaan waroeng',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 2,
            ],
            [
                'm_rekening_id' => 9,
                'm_rekening_m_waroeng_id'=> '001',
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'05.01.01',
                'm_rekening_nama'=>'biaya perbaikan waroeng',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 2,
            ],
            [
                'm_rekening_id' => 10,
                'm_rekening_m_waroeng_id'=> '001',
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'05.01.02',
                'm_rekening_nama'=>'biaya renovasi waroeng',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 2,
            ],
            [
                'm_rekening_id' => 11,
                'm_rekening_m_waroeng_id'=> '001',
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'05.01.03',
                'm_rekening_nama'=>'biaya fasilitas kantor waroeng',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 2,
            ],
            [
                'm_rekening_id' => 12,
                'm_rekening_m_waroeng_id'=> '001',
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'05.01.04',
                'm_rekening_nama'=>'biaya listrik, air, telepon waroeng',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 2,
            ],
            [
                'm_rekening_id' => 13,
                'm_rekening_m_waroeng_id'=> '001',
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'05.01.05',
                'm_rekening_nama'=>'biaya alat dan jaringan waroeng',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 2,
            ],
            [
                'm_rekening_id' => 14,
                'm_rekening_m_waroeng_id'=> '001',
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'05.01.06',
                'm_rekening_nama'=>'lelang',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 2,
            ],
            [
                'm_rekening_id' => 15,
                'm_rekening_m_waroeng_id'=> '001',
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'05.01.07',
                'm_rekening_nama'=>'penjualan barang bekas',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 2,
            ],
            [
                'm_rekening_id' => 16,
                'm_rekening_m_waroeng_id'=> '001',
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'05.01.08',
                'm_rekening_nama'=>'pendapatan lain-lain',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 2,
            ],
            [
                'm_rekening_id' => 17,
                'm_rekening_m_waroeng_id'=> '001',
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'05.01.09',
                'm_rekening_nama'=>'penjualan non menu',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 2,
            ],
            [
                'm_rekening_id' => 18,
                'm_rekening_m_waroeng_id'=> '001',
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'05.01.10',
                'm_rekening_nama'=>'penjualan wbd',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 2,
            ],
        ]);
    }
}