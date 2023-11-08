<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_supplier')->insert([
            'm_supplier_code' => '500001',
            'm_supplier_nama'=> 'Umum',
            'm_supplier_jth_tempo'=> 1,
            'm_supplier_alamat'=> 'Umum',
            'm_supplier_kota'=> 'Umum',
            'm_supplier_telp'=> 'Umum',
            'm_supplier_ket'=> 'Umum Tidak Kerjasama ',
            'm_supplier_rek_number'=> 1,
            'm_supplier_rek_nama'=> 'Bank Umum',
            'm_supplier_bank_nama'=> 'Bank Umum',
            'm_supplier_saldo_awal'=> 0,
            'm_supplier_created_by'=> 1, 
        ]);
    }
}
