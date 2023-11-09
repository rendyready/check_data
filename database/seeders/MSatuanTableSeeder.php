<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class MSatuanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_satuan')->truncate();

        DB::table('m_satuan')->insert([
            [
                'm_satuan_id' => '1',
                'm_satuan_kode' => 'kg',
                'm_satuan_keterangan' =>Null,
                'm_satuan_created_by' => 1
            ],
            [
                'm_satuan_id' => '2',
                'm_satuan_kode' => 'liter',
                'm_satuan_keterangan' =>Null,
                'm_satuan_created_by' => 1
            ],
            [
                'm_satuan_id' => '3',
                'm_satuan_kode' => 'biji / pcs',
                'm_satuan_keterangan' =>Null,
                'm_satuan_created_by' => 1
            ],
            [
                'm_satuan_id' => '4',
                'm_satuan_kode' => 'porsi',
                'm_satuan_keterangan' =>Null,
                'm_satuan_created_by' => 1
            ],
            [
                'm_satuan_id' => '5',
                'm_satuan_kode' => 'paket',
                'm_satuan_keterangan' =>Null,
                'm_satuan_created_by' => 1
            ],
            [
                'm_satuan_id' => '6',
                'm_satuan_kode' => 'pack',
                'm_satuan_keterangan' =>Null,
                'm_satuan_created_by' => 1
            ],
            [
                'm_satuan_id' => '7',
                'm_satuan_kode' => 'roll',
                'm_satuan_keterangan' =>Null,
                'm_satuan_created_by' => 1
            ],
            [
                'm_satuan_id' => '8',
                'm_satuan_kode' => 'botol',
                'm_satuan_keterangan' =>Null,
                'm_satuan_created_by' => 1
            ],
            [
                'm_satuan_id' => '9',
                'm_satuan_kode' => 'galon',
                'm_satuan_keterangan' =>Null,
                'm_satuan_created_by' => 1
            ],
            [
                'm_satuan_id' => '10',
                'm_satuan_kode' => 'bks',
                'm_satuan_keterangan' =>Null,
                'm_satuan_created_by' => 1
            ],
            [
                'm_satuan_id' => '11',
                'm_satuan_kode' => 'sachet',
                'm_satuan_keterangan' =>Null,
                'm_satuan_created_by' => 1
            ],
            [
                'm_satuan_id' => '12',
                'm_satuan_kode' => 'kaleng',
                'm_satuan_keterangan' =>Null,
                'm_satuan_created_by' => 1
            ],
        ]);
    }
}