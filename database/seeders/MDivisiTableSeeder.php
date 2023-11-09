<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MDivisiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_divisi')->truncate();

        DB::table('m_divisi')->insert([
            [
                'm_divisi_id' => 'MD112303011',
                'm_divisi_parent_id' => NULL,
                'm_divisi_name' => 'Divisi Support',
                'm_group_produk_created_by' => '2',
                'm_group_produk_created_by_name' => 'admin'
            ],
            [
                'm_divisi_id' => 'MD112303012',
                'm_divisi_parent_id' => NULL,
                'm_divisi_name' => 'Divisi Operasi',
                'm_group_produk_created_by' => '2',
                'm_group_produk_created_by_name' => 'admin'
            ],
            [
                'm_divisi_id' => 'MD112303013',
                'm_divisi_parent_id' => NULL,
                'm_divisi_name' => 'Divisi Keuangan',
                'm_group_produk_created_by' => '2',
                'm_group_produk_created_by_name' => 'admin'
            ],
            [
                'm_divisi_id' => 'MD112303014',
                'm_divisi_parent_id' => 'MD112303011',
                'm_divisi_name' => 'SDM',
                'm_group_produk_created_by' => '2',
                'm_group_produk_created_by_name' => 'admin'
            ],
            [
                'm_divisi_id' => 'MD112303015',
                'm_divisi_parent_id' => 'MD112303011',
                'm_divisi_name' => 'RTEO',
                'm_group_produk_created_by' => '2',
                'm_group_produk_created_by_name' => 'admin'
            ],
            [
                'm_divisi_id' => 'MD112303016',
                'm_divisi_parent_id' => 'MD112303011',
                'm_divisi_name' => 'IT',
                'm_group_produk_created_by' => '2',
                'm_group_produk_created_by_name' => 'admin'
            ],
        ]);
    }
}
