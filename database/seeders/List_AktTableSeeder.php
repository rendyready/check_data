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
                'm_link_akuntansi_nama' => 'Kas Transaksi - cash',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 2,
                'm_link_akuntansi_nama' => 'Nominal Transaksi - cash',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 3,
                'm_link_akuntansi_nama' => 'Pajak Transaksi - cash',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 4,
                'm_link_akuntansi_nama' => 'Service Charge Transaksi - cash',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 5,
                'm_link_akuntansi_nama' => 'Tarik Tunai Transaksi - cash',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 6,
                'm_link_akuntansi_nama' => 'Free Kembalian Transaksi - cash',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 7,
                'm_link_akuntansi_nama' => 'Pembulatan Transaksi - cash',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 8,
                'm_link_akuntansi_nama' => 'Diskon Transaksi - cash',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 9,
                'm_link_akuntansi_nama' => 'Persediaan Transaksi - cash',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 10,
                'm_link_akuntansi_nama' => 'Biaya Persediaan Transaksi - cash',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 11,
                'm_link_akuntansi_nama' => 'Kas Refund - cash',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 12,
                'm_link_akuntansi_nama' => 'Pajak Refund - cash',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 13,
                'm_link_akuntansi_nama' => 'Service Charge Refund - cash',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 14,
                'm_link_akuntansi_nama' => 'Pembulatan Refund - cash',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 15,
                'm_link_akuntansi_nama' => 'Free Kembalian Refund - cash',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 16,
                'm_link_akuntansi_nama' => 'Persediaan Refund - cash',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 17,
                'm_link_akuntansi_nama' => 'Biaya Persediaan Refund - cash',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 18,
                'm_link_akuntansi_nama' => 'Persediaan Lostbill',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 19,
                'm_link_akuntansi_nama' => 'Biaya Persediaan Lostbill',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 20,
                'm_link_akuntansi_nama' => 'Persediaan Garansi - cash',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
            [
                'm_link_akuntansi_id' => 21,
                'm_link_akuntansi_nama' => 'Biaya Persediaan Garansi - cash',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
            ],
        ]);
    }
}
