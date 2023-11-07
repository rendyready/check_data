<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AkuntansiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_akun_bank')->truncate();
        DB::table('m_akun_bank')->insert([
            [
                'm_akun_bank_id' => 1,
                'm_akun_bank_m_w_id' => 1,
                'm_akun_bank_type' => 'cash',
                'm_akun_bank_code' => 'CASH',
                'm_akun_bank_name' => 'CASH',
                // 'm_akun_bank_m_rekening_id' => 1,
                'm_akun_bank_created_by' => 1,
                'm_akun_bank_created_at' => Carbon::now(),
            ],
            [
                'm_akun_bank_id' => 2,
                'm_akun_bank_m_w_id' => 1,
                'm_akun_bank_type' => 'bank',
                'm_akun_bank_code' => 'MANDIRI',
                'm_akun_bank_name' => 'MANDIRI',
                // 'm_akun_bank_m_rekening_id' => 1,
                'm_akun_bank_created_by' => 1,
                'm_akun_bank_created_at' => Carbon::now(),
            ],
            [
                'm_akun_bank_id' => 3,
                'm_akun_bank_m_w_id' => 1,
                'm_akun_bank_type' => 'bank',
                'm_akun_bank_code' => 'BRI',
                'm_akun_bank_name' => 'BRI',
                // 'm_akun_bank_m_rekening_id' => 1,
                'm_akun_bank_created_by' => 1,
                'm_akun_bank_created_at' => Carbon::now(),
            ],
            [
                'm_akun_bank_id' => 4,
                'm_akun_bank_m_w_id' => 1,
                'm_akun_bank_type' => 'bank',
                'm_akun_bank_code' => 'BCA',
                'm_akun_bank_name' => 'BCA',
                // 'm_akun_bank_m_rekening_id' => 1,
                'm_akun_bank_created_by' => 1,
                'm_akun_bank_created_at' => Carbon::now(),
            ],
            [
                'm_akun_bank_id' => 5,
                'm_akun_bank_m_w_id' => 1,
                'm_akun_bank_type' => 'bank',
                'm_akun_bank_code' => 'BSI',
                'm_akun_bank_name' => 'BSI',
                // 'm_akun_bank_m_rekening_id' => 1,
                'm_akun_bank_created_by' => 1,
                'm_akun_bank_created_at' => Carbon::now(),
            ],
            [
                'm_akun_bank_id' => 6,
                'm_akun_bank_m_w_id' => 1,
                'm_akun_bank_type' => 'bank',
                'm_akun_bank_code' => 'BNI',
                'm_akun_bank_name' => 'BNI',
                // 'm_akun_bank_m_rekening_id' => 1,
                'm_akun_bank_created_by' => 1,
                'm_akun_bank_created_at' => Carbon::now(),
            ],
            [
                'm_akun_bank_id' => 7,
                'm_akun_bank_m_w_id' => 1,
                'm_akun_bank_type' => 'bank',
                'm_akun_bank_code' => 'MAYBANK',
                'm_akun_bank_name' => 'MAYBANK',
                // 'm_akun_bank_m_rekening_id' => 1,
                'm_akun_bank_created_by' => 1,
                'm_akun_bank_created_at' => Carbon::now(),
            ],
            [
                'm_akun_bank_id' => 8,
                'm_akun_bank_m_w_id' => 1,
                'm_akun_bank_type' => 'bank',
                'm_akun_bank_code' => 'GOPAY',
                'm_akun_bank_name' => 'GOPAY',
                // 'm_akun_bank_m_rekening_id' => 1,
                'm_akun_bank_created_by' => 1,
                'm_akun_bank_created_at' => Carbon::now(),
            ],
            [
                'm_akun_bank_id' => 9,
                'm_akun_bank_m_w_id' => 1,
                'm_akun_bank_type' => 'bank',
                'm_akun_bank_code' => 'OVO',
                'm_akun_bank_name' => 'OVO',
                // 'm_akun_bank_m_rekening_id' => 1,
                'm_akun_bank_created_by' => 1,
                'm_akun_bank_created_at' => Carbon::now(),
            ],
            [
                'm_akun_bank_id' => 5,
                'm_akun_bank_m_w_id' => 1,
                'm_akun_bank_type' => 'bank',
                'm_akun_bank_code' => 'SHOPEEPAY',
                'm_akun_bank_name' => 'SHOPEEPAY',
                // 'm_akun_bank_m_rekening_id' => 1,
                'm_akun_bank_created_by' => 1,
                'm_akun_bank_created_at' => Carbon::now(),
            ],
        ]);

        DB::table('m_rekening')->truncate();
        DB::table('m_rekening')->insert([
                [
                    "m_rekening_id" => 1,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "01.001",
                    "m_rekening_nama" => "kas waroeng",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 2,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "01.002",
                    "m_rekening_nama" => "bank waroeng",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 3,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "04.001",
                    "m_rekening_nama" => "pendapatan penjualan - menu",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 4,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "05.100",
                    "m_rekening_nama" => "biaya persediaan",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 5,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "01.004",
                    "m_rekening_nama" => "pajak ditahan",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 6,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "05.005",
                    "m_rekening_nama" => "biaya pembulatan",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 7,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "01.003",
                    "m_rekening_nama" => "voucer",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 8,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "05.007",
                    "m_rekening_nama" => "biaya diskon",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 9,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "05.006",
                    "m_rekening_nama" => "biaya free kembalian",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 10,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "01.100",
                    "m_rekening_nama" => "persediaan",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 11,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "05.008",
                    "m_rekening_nama" => "biaya refund",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 12,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "01.005",
                    "m_rekening_nama" => "tarik tunai",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 13,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "04.003",
                    "m_rekening_nama" => "pendapatan service charge",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 14,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "05.009",
                    "m_rekening_nama" => "selisih kasir",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 15,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "05.010",
                    "m_rekening_nama" => "biaya selisih kasir",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 16,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "04.002",
                    "m_rekening_nama" => "pendapatan lain-lain",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 17,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "05.011",
                    "m_rekening_nama" => "biaya lostbill",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 18,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "04.004",
                    "m_rekening_nama" => "pendapatan penjualan - non menu",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 19,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "04.005",
                    "m_rekening_nama" => "pendapatan penjualan - wbd",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 20,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "04.006",
                    "m_rekening_nama" => "pendapatan penjualan - diluar usaha",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 21,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "01.006",
                    "m_rekening_nama" => "ayat silang mandiri",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 22,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "01.007",
                    "m_rekening_nama" => "ayat silang bca",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 23,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "01.008",
                    "m_rekening_nama" => "ayat silang grab",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 24,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "01.009",
                    "m_rekening_nama" => "ayat silang shopee",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 25,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "01.010",
                    "m_rekening_nama" => "ayat silang gojek",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 26,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "01.011",
                    "m_rekening_nama" => "mutasi kas keluar",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 27,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "01.012",
                    "m_rekening_nama" => "mutasi kas masuk",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 28,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "05.012",
                    "m_rekening_nama" => "biaya garansi",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 29,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "05.013",
                    "m_rekening_nama" => "biaya lain - lain",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 30,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "01.013",
                    "m_rekening_nama" => "sharing profit ditahan",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 31,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => '210200000',
                    "m_rekening_nama" => "hutang deviden",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 32,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => '210700000',
                    "m_rekening_nama" => "hutang bb",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 33,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => '210800000',
                    "m_rekening_nama" => "hutang bb tidak langsung",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 34,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => '210900000',
                    "m_rekening_nama" => "hutang bb operasional",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 35,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => '211000000',
                    "m_rekening_nama" => "hutang lain-lain",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 36,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => '220010000',
                    "m_rekening_nama" => "hutang leasing",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 37,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => '240010000',
                    "m_rekening_nama" => "hutang pajak",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 38,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => '250000000',
                    "m_rekening_nama" => "hutang dana pajak csr",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 39,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => '260000000',
                    "m_rekening_nama" => "hutang dana pajak investasi",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 40,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => '270000000',
                    "m_rekening_nama" => "hutang dana pajak direktur",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 41,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => '281000000',
                    "m_rekening_nama" => "hutang danpen",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 42,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => '282000000',
                    "m_rekening_nama" => "hutang profit sharing",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 43,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => '283000000',
                    "m_rekening_nama" => "hutang gaji",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 44,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => '284000000',
                    "m_rekening_nama" => "hutang dansos",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 45,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => '285000000',
                    "m_rekening_nama" => "hutang koperasi",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 46,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => '286000000',
                    "m_rekening_nama" => "hutang koperasi eskternal",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 47,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => '287000000',
                    "m_rekening_nama" => "hutang dana pajak aparatur",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 48,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => '280000000',
                    "m_rekening_nama" => "hutang usaha",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 49,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "05.014",
                    "m_rekening_nama" => "piutang dagang",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 50,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "01.014",
                    "m_rekening_nama" => "hutang dagang",
                    "m_rekening_created_by" => 1
                ],
                [
                    "m_rekening_id" => 51,
                    "m_rekening_m_w_id" => 1,
                    "m_rekening_m_w_code" => "001",
                    "m_rekening_kategori" => "aktiva lancar",
                    "m_rekening_code" => "10.16",
                    "m_rekening_nama" => "biaya stock opname",
                    "m_rekening_created_by" => 1
                ]
        ]);

        DB::table('m_link_akuntansi')->truncate();
        DB::table('m_link_akuntansi')->insert([
                [
                    "m_link_akuntansi_id" => 1,
                    "m_link_akuntansi_nama" => "Kas Transaksi",
                    "m_link_akuntansi_m_rekening_id" => 1,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 2,
                    "m_link_akuntansi_nama" => "Nominal Transaksi - Menu",
                    "m_link_akuntansi_m_rekening_id" => 3,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 3,
                    "m_link_akuntansi_nama" => "Nominal Transaksi - Non Menu",
                    "m_link_akuntansi_m_rekening_id" => 37,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 4,
                    "m_link_akuntansi_nama" => "Nominal Transaksi - WBD",
                    "m_link_akuntansi_m_rekening_id" => 38,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 5,
                    "m_link_akuntansi_nama" => "Nominal Transaksi - Diluar Usaha",
                    "m_link_akuntansi_m_rekening_id" => 39,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 6,
                    "m_link_akuntansi_nama" => "Service Charge Transaksi",
                    "m_link_akuntansi_m_rekening_id" => 13,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 7,
                    "m_link_akuntansi_nama" => "Tarik Tunai Transaksi",
                    "m_link_akuntansi_m_rekening_id" => 30,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 8,
                    "m_link_akuntansi_nama" => "Free Kembalian Transaksi",
                    "m_link_akuntansi_m_rekening_id" => 9,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 9,
                    "m_link_akuntansi_nama" => "Pembulatan Transaksi",
                    "m_link_akuntansi_m_rekening_id" => 24,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 10,
                    "m_link_akuntansi_nama" => "Diskon Transaksi",
                    "m_link_akuntansi_m_rekening_id" => 26,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 11,
                    "m_link_akuntansi_nama" => "Persediaan Transaksi",
                    "m_link_akuntansi_m_rekening_id" => 10,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 12,
                    "m_link_akuntansi_nama" => "Biaya Persediaan Transaksi",
                    "m_link_akuntansi_m_rekening_id" => 22,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 13,
                    "m_link_akuntansi_nama" => "Penjualan Refund",
                    "m_link_akuntansi_m_rekening_id" => 1,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 14,
                    "m_link_akuntansi_nama" => "Nominal Refund - Menu",
                    "m_link_akuntansi_m_rekening_id" => 3,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 15,
                    "m_link_akuntansi_nama" => "Pajak Refund",
                    "m_link_akuntansi_m_rekening_id" => 5,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 16,
                    "m_link_akuntansi_nama" => "Service Charge Refund",
                    "m_link_akuntansi_m_rekening_id" => 13,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 17,
                    "m_link_akuntansi_nama" => "Pembulatan Refund",
                    "m_link_akuntansi_m_rekening_id" => 24,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 18,
                    "m_link_akuntansi_nama" => "Free Kembalian Refund",
                    "m_link_akuntansi_m_rekening_id" => 9,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 19,
                    "m_link_akuntansi_nama" => "Persediaan Refund",
                    "m_link_akuntansi_m_rekening_id" => 10,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 20,
                    "m_link_akuntansi_nama" => "Biaya Persediaan Refund",
                    "m_link_akuntansi_m_rekening_id" => 22,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 21,
                    "m_link_akuntansi_nama" => "Persediaan Lostbill",
                    "m_link_akuntansi_m_rekening_id" => 10,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 22,
                    "m_link_akuntansi_nama" => "Biaya Persediaan Lostbill",
                    "m_link_akuntansi_m_rekening_id" => 22,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 23,
                    "m_link_akuntansi_nama" => "Persediaan Garansi",
                    "m_link_akuntansi_m_rekening_id" => 10,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 24,
                    "m_link_akuntansi_nama" => "Biaya Persediaan Garansi",
                    "m_link_akuntansi_m_rekening_id" => 22,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 25,
                    "m_link_akuntansi_nama" => "Bank Mandiri",
                    "m_link_akuntansi_m_rekening_id" => 40,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 26,
                    "m_link_akuntansi_nama" => "Bank BCA",
                    "m_link_akuntansi_m_rekening_id" => 41,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 27,
                    "m_link_akuntansi_nama" => "Ovo",
                    "m_link_akuntansi_m_rekening_id" => 42,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 28,
                    "m_link_akuntansi_nama" => "Shopee",
                    "m_link_akuntansi_m_rekening_id" => 43,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 29,
                    "m_link_akuntansi_nama" => "Gopay",
                    "m_link_akuntansi_m_rekening_id" => 44,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 30,
                    "m_link_akuntansi_nama" => "Mutasi Keluar",
                    "m_link_akuntansi_m_rekening_id" => 45,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 31,
                    "m_link_akuntansi_nama" => "Mutasi Masuk",
                    "m_link_akuntansi_m_rekening_id" => 46,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 32,
                    "m_link_akuntansi_nama" => "Selisih Kasir",
                    "m_link_akuntansi_m_rekening_id" => 1,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 33,
                    "m_link_akuntansi_nama" => "Biaya Selisih Kasir",
                    "m_link_akuntansi_m_rekening_id" => 1,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 34,
                    "m_link_akuntansi_nama" => "Biaya Refund",
                    "m_link_akuntansi_m_rekening_id" => 11,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 35,
                    "m_link_akuntansi_nama" => "Biaya Lostbill",
                    "m_link_akuntansi_m_rekening_id" => 36,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 36,
                    "m_link_akuntansi_nama" => "Biaya Garansi",
                    "m_link_akuntansi_m_rekening_id" => 47,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 37,
                    "m_link_akuntansi_nama" => "Nominal Refund - Non Menu",
                    "m_link_akuntansi_m_rekening_id" => 37,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 38,
                    "m_link_akuntansi_nama" => "Nominal Refund - WBD",
                    "m_link_akuntansi_m_rekening_id" => 38,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 39,
                    "m_link_akuntansi_nama" => "Nominal Refund - Diluar Usaha",
                    "m_link_akuntansi_m_rekening_id" => 39,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 40,
                    "m_link_akuntansi_nama" => "Nominal Lostbill - Menu",
                    "m_link_akuntansi_m_rekening_id" => 3,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 41,
                    "m_link_akuntansi_nama" => "Nominal Lostbill - Non Menu",
                    "m_link_akuntansi_m_rekening_id" => 37,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 42,
                    "m_link_akuntansi_nama" => "Nominal Lostbill - WBD",
                    "m_link_akuntansi_m_rekening_id" => 38,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 43,
                    "m_link_akuntansi_nama" => "Nominal Lostbill - Diluar Usaha",
                    "m_link_akuntansi_m_rekening_id" => 39,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 44,
                    "m_link_akuntansi_nama" => "Pajak Lostbill",
                    "m_link_akuntansi_m_rekening_id" => 5,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 45,
                    "m_link_akuntansi_nama" => "Nominal Garansi - Menu",
                    "m_link_akuntansi_m_rekening_id" => 3,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 46,
                    "m_link_akuntansi_nama" => "Nominal Garansi - Non Menu",
                    "m_link_akuntansi_m_rekening_id" => 37,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 47,
                    "m_link_akuntansi_nama" => "Nominal Garansi - WBD",
                    "m_link_akuntansi_m_rekening_id" => 38,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 48,
                    "m_link_akuntansi_nama" => "Nominal Garansi - Diluar Usaha",
                    "m_link_akuntansi_m_rekening_id" => 39,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 49,
                    "m_link_akuntansi_nama" => "Pajak Garansi",
                    "m_link_akuntansi_m_rekening_id" => 5,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 50,
                    "m_link_akuntansi_nama" => "Pajak Transaksi",
                    "m_link_akuntansi_m_rekening_id" => 5,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 51,
                    "m_link_akuntansi_nama" => "Penjualan Lostbill",
                    "m_link_akuntansi_m_rekening_id" => 1,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 52,
                    "m_link_akuntansi_nama" => "Penjualan Garansi",
                    "m_link_akuntansi_m_rekening_id" => 1,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 53,
                    "m_link_akuntansi_nama" => "Pendapatan Selisih Kasir",
                    "m_link_akuntansi_m_rekening_id" => 1,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 54,
                    "m_link_akuntansi_nama" => "Biaya Selisih Kasir",
                    "m_link_akuntansi_m_rekening_id" => 1,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 55,
                    "m_link_akuntansi_nama" => "Kas Mutasi",
                    "m_link_akuntansi_m_rekening_id" => 1,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 56,
                    "m_link_akuntansi_nama" => "Nominal Transaksi - Lain - Lain",
                    "m_link_akuntansi_m_rekening_id" => 34,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 57,
                    "m_link_akuntansi_nama" => "Nominal Refund - Lain - Lain",
                    "m_link_akuntansi_m_rekening_id" => 34,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 58,
                    "m_link_akuntansi_nama" => "Nominal Lostbill - Lain - Lain",
                    "m_link_akuntansi_m_rekening_id" => 34,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 59,
                    "m_link_akuntansi_nama" => "Nominal Garansi - Lain - Lain",
                    "m_link_akuntansi_m_rekening_id" => 34,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 60,
                    "m_link_akuntansi_nama" => "Nominal Tambahan Ojol",
                    "m_link_akuntansi_m_rekening_id" => 5,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 61,
                    "m_link_akuntansi_nama" => "Mutasi Keluar Ojol",
                    "m_link_akuntansi_m_rekening_id" => 45,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 62,
                    "m_link_akuntansi_nama" => "Mutasi Masuk Ojol",
                    "m_link_akuntansi_m_rekening_id" => 46,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 63,
                    "m_link_akuntansi_nama" => "Hutang Dagang",
                    "m_link_akuntansi_m_rekening_id" => 49,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 64,
                    "m_link_akuntansi_nama" => "Piutang Dagang",
                    "m_link_akuntansi_m_rekening_id" => 50,
                    "m_link_akuntansi_created_by" => 1
                ],
                [
                    "m_link_akuntansi_id" => 65,
                    "m_link_akuntansi_nama" => "Biaya Stock Opname",
                    "m_link_akuntansi_m_rekening_id" => 51,
                    "m_link_akuntansi_created_by" => 1
                ]
        ]);
    }
}
