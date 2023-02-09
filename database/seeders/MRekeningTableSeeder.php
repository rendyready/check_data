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
                'm_rekening_m_waroeng_id'=> 1,
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'01.01.01',
                'm_rekening_nama'=>'kas',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 1,
            ],
            [
                'm_rekening_m_waroeng_id'=> 1,
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'01.02.01',
                'm_rekening_nama'=>'bank',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 1,
            ],
            [
                'm_rekening_m_waroeng_id'=> 1,
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'01.11.01',
                'm_rekening_nama'=>'persediaan bahan baku',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 1,
            ],
            [
                'm_rekening_m_waroeng_id'=> 1,
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'01.12.01',
                'm_rekening_nama'=>'persediaan bahan produksi',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 1,
            ],
            [
                'm_rekening_m_waroeng_id'=> 1,
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'02.02.01',
                'm_rekening_nama'=>'hutang suplier',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 1,
            ],
            [
                'm_rekening_m_waroeng_id'=> 1,
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'04.01.01',
                'm_rekening_nama'=>'pendapatan penjualan',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 1,
            ],
            [
                'm_rekening_m_waroeng_id'=> 1,
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'04.02.01',
                'm_rekening_nama'=>'pendapatan lain - lain',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 1,
            ],
            [
                'm_rekening_m_waroeng_id'=> 1,
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'05.01.01',
                'm_rekening_nama'=>'biaya hpp penjualan',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 1,
            ],
            [
                'm_rekening_m_waroeng_id'=> 1,
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'05.01.01',
                'm_rekening_nama'=>'biaya hpp penjualan scp',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 1,
            ],
            [
                'm_rekening_m_waroeng_id'=> 1,
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'05.01.02',
                'm_rekening_nama'=>'biaya hpp bahan produksi',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 1,
            ],
            [
                'm_rekening_m_waroeng_id'=> 1,
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'05.01.03',
                'm_rekening_nama'=>'biaya akomodasi',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 1,
            ],
            [
                'm_rekening_m_waroeng_id'=> 1,
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'05.01.04',
                'm_rekening_nama'=>'biaya rusak',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 1,
            ],
            [
                'm_rekening_m_waroeng_id'=> 1,
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'05.01.05',
                'm_rekening_nama'=>'biaya lpg',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 1,
            ],
            [
                'm_rekening_m_waroeng_id'=> 1,
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'05.01.06',
                'm_rekening_nama'=>'biaya ppn pembelian',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 1,
            ],
            [
                'm_rekening_m_waroeng_id'=> 1,
                'm_rekening_kategori'=>'aktiva lancar',
                'm_rekening_no_akun'=>'05.01.07',
                'm_rekening_nama'=>'biaya ongkir pembelian',
                'm_rekening_saldo'=>1000000,
                'm_rekening_created_by'=> 1,
            ],
        ]);
    }
}