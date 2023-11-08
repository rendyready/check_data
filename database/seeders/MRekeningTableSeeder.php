<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                'm_rekening_m_waroeng_id' => 1,
                'm_rekening_kategori' => 'aktiva lancar',
                'm_rekening_no_akun' => '01.001',
                'm_rekening_nama' => 'kas waroeng',
                'm_rekening_saldo' => 1000000,
                'm_rekening_created_by' => 2,
            ],
            [
                'm_rekening_id' => 2,
                'm_rekening_m_waroeng_id' => 1,
                'm_rekening_kategori' => 'aktiva lancar',
                'm_rekening_no_akun' => '01.002',
                'm_rekening_nama' => 'bank transfer',
                'm_rekening_saldo' => 1000000,
                'm_rekening_created_by' => 2,
            ],
            [
                'm_rekening_id' => 3,
                'm_rekening_m_waroeng_id' => 1,
                'm_rekening_kategori' => 'aktiva lancar',
                'm_rekening_no_akun' => '01.003',
                'm_rekening_nama' => 'voucer',
                'm_rekening_saldo' => 1000000,
                'm_rekening_created_by' => 2,
            ],
            [
                'm_rekening_id' => 4,
                'm_rekening_m_waroeng_id' => 1,
                'm_rekening_kategori' => 'aktiva lancar',
                'm_rekening_no_akun' => '01.004',
                'm_rekening_nama' => 'pajak ditahan',
                'm_rekening_saldo' => 1000000,
                'm_rekening_created_by' => 2,
            ],
            [
                'm_rekening_id' => 5,
                'm_rekening_m_waroeng_id' => 1,
                'm_rekening_kategori' => 'aktiva lancar',
                'm_rekening_no_akun' => '01.005',
                'm_rekening_nama' => 'tarik tunai',
                'm_rekening_saldo' => 1000000,
                'm_rekening_created_by' => 2,
            ],
            [
                'm_rekening_id' => 6,
                'm_rekening_m_waroeng_id' => 1,
                'm_rekening_kategori' => 'aktiva lancar',
                'm_rekening_no_akun' => '04.001',
                'm_rekening_nama' => 'pendapatan penjualan',
                'm_rekening_saldo' => 1000000,
                'm_rekening_created_by' => 2,
            ],
            [
                'm_rekening_id' => 7,
                'm_rekening_m_waroeng_id' => 1,
                'm_rekening_kategori' => 'aktiva lancar',
                'm_rekening_no_akun' => '01.100',
                'm_rekening_nama' => 'persediaan',
                'm_rekening_saldo' => 1000000,
                'm_rekening_created_by' => 2,
            ],
            [
                'm_rekening_id' => 8,
                'm_rekening_m_waroeng_id' => 1,
                'm_rekening_kategori' => 'aktiva lancar',
                'm_rekening_no_akun' => '04.001',
                'm_rekening_nama' => 'pendapatan penjualan',
                'm_rekening_saldo' => 1000000,
                'm_rekening_created_by' => 2,
            ],
            [
                'm_rekening_id' => 9,
                'm_rekening_m_waroeng_id' => 1,
                'm_rekening_kategori' => 'aktiva lancar',
                'm_rekening_no_akun' => '04.002',
                'm_rekening_nama' => 'pendapatan lain-lain',
                'm_rekening_saldo' => 1000000,
                'm_rekening_created_by' => 2,
            ],
            [
                'm_rekening_id' => 10,
                'm_rekening_m_waroeng_id' => 1,
                'm_rekening_kategori' => 'aktiva lancar',
                'm_rekening_no_akun' => '04.003',
                'm_rekening_nama' => 'pendapatan service charge',
                'm_rekening_saldo' => 1000000,
                'm_rekening_created_by' => 2,
            ],
            [
                'm_rekening_id' => 11,
                'm_rekening_m_waroeng_id' => 1,
                'm_rekening_kategori' => 'aktiva lancar',
                'm_rekening_no_akun' => '05.005',
                'm_rekening_nama' => 'biaya pembulatan',
                'm_rekening_saldo' => 1000000,
                'm_rekening_created_by' => 2,
            ],
            [
                'm_rekening_id' => 12,
                'm_rekening_m_waroeng_id' => 1,
                'm_rekening_kategori' => 'aktiva lancar',
                'm_rekening_no_akun' => '05.006',
                'm_rekening_nama' => 'biaya free kembalian',
                'm_rekening_saldo' => 1000000,
                'm_rekening_created_by' => 2,
            ],
            [
                'm_rekening_id' => 13,
                'm_rekening_m_waroeng_id' => 1,
                'm_rekening_kategori' => 'aktiva lancar',
                'm_rekening_no_akun' => '05.007',
                'm_rekening_nama' => 'biaya diskon',
                'm_rekening_saldo' => 1000000,
                'm_rekening_created_by' => 2,
            ],
            [
                'm_rekening_id' => 14,
                'm_rekening_m_waroeng_id' => 1,
                'm_rekening_kategori' => 'aktiva lancar',
                'm_rekening_no_akun' => '05.008',
                'm_rekening_nama' => 'biaya refund',
                'm_rekening_saldo' => 1000000,
                'm_rekening_created_by' => 2,
            ],
            [
                'm_rekening_id' => 15,
                'm_rekening_m_waroeng_id' => 1,
                'm_rekening_kategori' => 'aktiva lancar',
                'm_rekening_no_akun' => '05.008',
                'm_rekening_nama' => 'biaya listrik, air, telepon waroeng',
                'm_rekening_saldo' => 1000000,
                'm_rekening_created_by' => 2,
            ],
            [
                'm_rekening_id' => 16,
                'm_rekening_m_waroeng_id' => 74,
                'm_rekening_kategori' => 'aktiva lancar',
                'm_rekening_no_akun' => '05.100',
                'm_rekening_nama' => 'biaya persediaan',
                'm_rekening_saldo' => 1000000,
                'm_rekening_created_by' => 2,
            ],
        ]);
    }
}
