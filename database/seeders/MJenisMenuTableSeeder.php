<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class MJenisMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_menu_jenis')->truncate();

        DB::table('m_menu_jenis')->insert([
            [
                'm_menu_jenis_nama' => 'Minuman',
                'm_menu_jenis_odcr55' => 'minum',
                'm_menu_jenis_created_by' => 1,
                'm_menu_jenis_urut' => 1
            ],
            [
                'm_menu_jenis_nama' => 'Buah',
                'm_menu_jenis_odcr55' => 'minum',
                'm_menu_jenis_created_by' => 1,
                'm_menu_jenis_urut' => 2
            ],
            [
                'm_menu_jenis_nama' => 'Sambal',
                'm_menu_jenis_odcr55' => 'makan',
                'm_menu_jenis_created_by' => 1,
                'm_menu_jenis_urut' => 3
            ],
            [
                'm_menu_jenis_nama' => 'Lauk',
                'm_menu_jenis_odcr55' => 'makan',
                'm_menu_jenis_created_by' => 1,
                'm_menu_jenis_urut' => 4
            ],
            [
                'm_menu_jenis_nama' => 'Sayur',
                'm_menu_jenis_odcr55' => 'makan',
                'm_menu_jenis_created_by' => 1,
                'm_menu_jenis_urut' => 5
            ],
            [
                'm_menu_jenis_nama' => 'Nasi',
                'm_menu_jenis_odcr55' => 'makan',
                'm_menu_jenis_created_by' => 1,
                'm_menu_jenis_urut' => 6
            ],
            [
                'm_menu_jenis_nama' => 'Paket',
                'm_menu_jenis_odcr55' => 'makan',
                'm_menu_jenis_created_by' => 1,
                'm_menu_jenis_urut' => 7
            ],
            [
                'm_menu_jenis_nama' => 'Lain-lain',
                'm_menu_jenis_odcr55' => null,
                'm_menu_jenis_created_by' => 1,
                'm_menu_jenis_urut' => 8
            ],
            [
                'm_menu_jenis_nama' => 'Non-Menu',
                'm_menu_jenis_odcr55' => 'minum',
                'm_menu_jenis_created_by' => 1,
                'm_menu_jenis_urut' => 9
            ],  
            [
                'm_menu_jenis_nama' => 'Promo',
                'm_menu_jenis_odcr55' => 'makan',
                'm_menu_jenis_created_by' => 1,
                'm_menu_jenis_urut' => 10
            ],
            [
                'm_menu_jenis_nama' => 'WBD-Corner',
                'm_menu_jenis_odcr55' => 'makan',
                'm_menu_jenis_created_by' => 1,
                'm_menu_jenis_urut' => 11
            ],
            [
                'm_menu_jenis_nama' => 'Mutasi-WBD',
                'm_menu_jenis_odcr55' => 'makan',
                'm_menu_jenis_created_by' => 1,
                'm_menu_jenis_urut' => 12
            ]
          
         
        ]);
    }
}
