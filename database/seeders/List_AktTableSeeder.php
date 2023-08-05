<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                'm_link_akuntansi_nama' => 'Kas Transaksi',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '01.001',
            ],
            [
                'm_link_akuntansi_id' => 2,
                'm_link_akuntansi_nama' => 'Nominal Transaksi - Menu',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 3,
                'm_link_akuntansi_nama' => 'Nominal Transaksi - Non Menu',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 4,
                'm_link_akuntansi_nama' => 'Nominal Transaksi - WBD',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 5,
                'm_link_akuntansi_nama' => 'Nominal Transaksi - Diluar Usaha',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 6,
                'm_link_akuntansi_nama' => 'Service Charge Transaksi',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '04.003',
            ],
            [
                'm_link_akuntansi_id' => 7,
                'm_link_akuntansi_nama' => 'Tarik Tunai Transaksi',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '01.005',
            ],
            [
                'm_link_akuntansi_id' => 8,
                'm_link_akuntansi_nama' => 'Free Kembalian Transaksi',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '05.006',
            ],
            [
                'm_link_akuntansi_id' => 9,
                'm_link_akuntansi_nama' => 'Pembulatan Transaksi',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '05.005',
            ],
            [
                'm_link_akuntansi_id' => 10,
                'm_link_akuntansi_nama' => 'Diskon Transaksi',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '05.007',
            ],
            [
                'm_link_akuntansi_id' => 11,
                'm_link_akuntansi_nama' => 'Persediaan Transaksi',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '01.100',
            ],
            [
                'm_link_akuntansi_id' => 12,
                'm_link_akuntansi_nama' => 'Biaya Persediaan Transaksi',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '05.100',
            ],
            [
                'm_link_akuntansi_id' => 13,
                'm_link_akuntansi_nama' => 'Kas Refund',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '01.001',
            ],
            [
                'm_link_akuntansi_id' => 14,
                'm_link_akuntansi_nama' => 'Nominal Refund',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '04.001',
            ],
            [
                'm_link_akuntansi_id' => 15,
                'm_link_akuntansi_nama' => 'Pajak Refund',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '01.004',
            ],
            [
                'm_link_akuntansi_id' => 16,
                'm_link_akuntansi_nama' => 'Service Charge Refund',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '04.003',
            ],
            [
                'm_link_akuntansi_id' => 17,
                'm_link_akuntansi_nama' => 'Pembulatan Refund',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '05.005',
            ],
            [
                'm_link_akuntansi_id' => 18,
                'm_link_akuntansi_nama' => 'Free Kembalian Refund',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '05.006',
            ],
            [
                'm_link_akuntansi_id' => 19,
                'm_link_akuntansi_nama' => 'Persediaan Refund',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '01.100',
            ],
            [
                'm_link_akuntansi_id' => 20,
                'm_link_akuntansi_nama' => 'Biaya Persediaan Refund',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '05.100',
            ],
            [
                'm_link_akuntansi_id' => 21,
                'm_link_akuntansi_nama' => 'Persediaan Lostbill',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '01.100',
            ],
            [
                'm_link_akuntansi_id' => 22,
                'm_link_akuntansi_nama' => 'Biaya Persediaan Lostbill',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '05.100',
            ],
            [
                'm_link_akuntansi_id' => 23,
                'm_link_akuntansi_nama' => 'Persediaan Garansi',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '01.100',
            ],
            [
                'm_link_akuntansi_id' => 24,
                'm_link_akuntansi_nama' => 'Biaya Persediaan Garansi',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '05.100',
            ],
            [
                'm_link_akuntansi_id' => 25,
                'm_link_akuntansi_nama' => 'Bank Mandiri (inc. BNI & BRI)',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 26,
                'm_link_akuntansi_nama' => 'Bank BCA (inc. QRIS)',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 27,
                'm_link_akuntansi_nama' => 'Ojol - Ovo',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 28,
                'm_link_akuntansi_nama' => 'Ojol - Shopee',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 29,
                'm_link_akuntansi_nama' => 'Ojol - Gopay',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 30,
                'm_link_akuntansi_nama' => 'Mutasi Keluar',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 31,
                'm_link_akuntansi_nama' => 'Mutasi Masuk',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 32,
                'm_link_akuntansi_nama' => 'Selisih Kasir',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 33,
                'm_link_akuntansi_nama' => 'Biaya Selisih Kasir',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 33,
                'm_link_akuntansi_nama' => 'Biaya Refund',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 34,
                'm_link_akuntansi_nama' => 'Biaya Lostbill',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 35,
                'm_link_akuntansi_nama' => 'Biaya Garansi',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
        ]);
    }
}
