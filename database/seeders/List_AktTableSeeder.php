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
                'm_link_akuntansi_m_rekening_no_akun' => '',
                'm_link_akuntansi_field_sync' => json_encode(['r_t_nominal', 'r_t_nominal_pajak', 'r_t_nominal_sc', 'r_t_nominal_tarik_tunai', 'r_t_nominal_free_kembalian', 'r_t_nominal_pembulatan', 'r_t_nominal_diskon']),
            ],
            [
                'm_link_akuntansi_id' => 2,
                'm_link_akuntansi_nama' => 'Nominal Transaksi',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
                'm_link_akuntansi_field_sync' => json_encode('r_t_nominal'),
            ],
            [
                'm_link_akuntansi_id' => 3,
                'm_link_akuntansi_nama' => 'Pajak Transaksi',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
                'm_link_akuntansi_field_sync' => json_encode('r_t_nominal_pajak'),
            ],
            [
                'm_link_akuntansi_id' => 4,
                'm_link_akuntansi_nama' => 'Service Charge Transaksi',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
                'm_link_akuntansi_field_sync' => json_encode('r_t_nominal_sc'),
            ],
            [
                'm_link_akuntansi_id' => 5,
                'm_link_akuntansi_nama' => 'Tarik Tunai Transaksi',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
                'm_link_akuntansi_field_sync' => json_encode('r_t_nominal_tarik_tunai'),
            ],
            [
                'm_link_akuntansi_id' => 6,
                'm_link_akuntansi_nama' => 'Free Kembalian Transaksi',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
                'm_link_akuntansi_field_sync' => json_encode('r_t_nominal_free_kembalian'),
            ],
            [
                'm_link_akuntansi_id' => 7,
                'm_link_akuntansi_nama' => 'Pembulatan Transaksi',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
                'm_link_akuntansi_field_sync' => json_encode('r_t_nominal_pembulatan'),
            ],
            [
                'm_link_akuntansi_id' => 8,
                'm_link_akuntansi_nama' => 'Diskon Transaksi',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
                'm_link_akuntansi_field_sync' => json_encode('r_t_nominal_diskon'),
            ],
            [
                'm_link_akuntansi_id' => 9,
                'm_link_akuntansi_nama' => 'Persediaan Transaksi',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
                'm_link_akuntansi_field_sync' => json_encode('r_t_nominal'),
            ],
            [
                'm_link_akuntansi_id' => 10,
                'm_link_akuntansi_nama' => 'Biaya Persediaan Transaksi',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
                'm_link_akuntansi_field_sync' => json_encode('r_t_nominal'),
            ],
            [
                'm_link_akuntansi_id' => 11,
                'm_link_akuntansi_nama' => 'Kas Refund',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
                'm_link_akuntansi_field_sync' => json_encode(['r_r_nominal_refund', 'r_r_nominal_refund_pajak', 'r_r_nominal_refund_sc', 'r_r_nominal_pembulatan_refund', 'r_r_nominal_free_kembalian_refund']),
            ],
            [
                'm_link_akuntansi_id' => 12,
                'm_link_akuntansi_nama' => 'Pajak Refund',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
                'm_link_akuntansi_field_sync' => json_encode('r_r_nominal_refund_pajak'),
            ],
            [
                'm_link_akuntansi_id' => 13,
                'm_link_akuntansi_nama' => 'Service Charge Refund',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
                'm_link_akuntansi_field_sync' => json_encode('r_r_nominal_refund_sc'),
            ],
            [
                'm_link_akuntansi_id' => 14,
                'm_link_akuntansi_nama' => 'Pembulatan Refund',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
                'm_link_akuntansi_field_sync' => json_encode('r_r_nominal_pembulatan_refund'),
            ],
            [
                'm_link_akuntansi_id' => 15,
                'm_link_akuntansi_nama' => 'Free Kembalian Refund',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
                'm_link_akuntansi_field_sync' => json_encode('r_r_nominal_free_kembalian_refund'),
            ],
            [
                'm_link_akuntansi_id' => 16,
                'm_link_akuntansi_nama' => 'Persediaan Refund',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
                'm_link_akuntansi_field_sync' => json_encode('r_r_nominal_refund'),
            ],
            [
                'm_link_akuntansi_id' => 17,
                'm_link_akuntansi_nama' => 'Biaya Persediaan Refund',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
                'm_link_akuntansi_field_sync' => json_encode('r_r_nominal_refund'),
            ],
            [
                'm_link_akuntansi_id' => 18,
                'm_link_akuntansi_nama' => 'Persediaan Lostbill',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
                'm_link_akuntansi_field_sync' => json_encode('r_l_b_nominal'),
            ],
            [
                'm_link_akuntansi_id' => 19,
                'm_link_akuntansi_nama' => 'Biaya Persediaan Lostbill',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
                'm_link_akuntansi_field_sync' => json_encode('r_l_b_nominal'),
            ],
            [
                'm_link_akuntansi_id' => 20,
                'm_link_akuntansi_nama' => 'Persediaan Garansi',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
                'm_link_akuntansi_field_sync' => json_encode('rekap_garansi_nominal'),
            ],
            [
                'm_link_akuntansi_id' => 21,
                'm_link_akuntansi_nama' => 'Biaya Persediaan Garansi',
                'm_link_akuntansi_created_by' => 1,
                'm_link_akuntansi_m_rekening_no_akun' => '',
                'm_link_akuntansi_field_sync' => json_encode('rekap_garansi_nominal'),
            ],
        ]);
    }
}
