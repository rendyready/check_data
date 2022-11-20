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
                'm_satuan_kode' => 'Kilogram',
                'm_satuan_keterangan' =>Null,
                'm_satuan_created_by' => 1
            ],
            [
                'm_satuan_kode' => 'Liter',
                'm_satuan_keterangan' =>Null,
                'm_satuan_created_by' => 1
            ],
            [
                'm_satuan_kode' => 'Biji / Pcs',
                'm_satuan_keterangan' =>Null,
                'm_satuan_created_by' => 1
            ],
        ]);
    }
}