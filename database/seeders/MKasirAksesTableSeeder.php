<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MKasirAksesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_kasir_akses')->truncate();

        DB::table('m_kasir_akses')->insert([
            [
                'm_kasir_akses_id' => '1',
                'm_kasir_akses_m_w_id' => 1,
                'm_kasir_akses_fitur' => 'edit_menu',
                'm_kasir_akses_default_role' => 'deny',
                'm_kasir_akses_temp_role' => 'deny',
                'm_kasir_akses_created_by' => 1
            ],
            [
                'm_kasir_akses_id' => '2',
                'm_kasir_akses_m_w_id' => 1,
                'm_kasir_akses_fitur' => 'cancel_menu',
                'm_kasir_akses_default_role' => 'allow',
                'm_kasir_akses_temp_role' => 'allow',
                'm_kasir_akses_created_by' => 1
            ],
            [
                'm_kasir_akses_id' => '3',
                'm_kasir_akses_m_w_id' => 1,
                'm_kasir_akses_fitur' => 'cancel_transaksi',
                'm_kasir_akses_default_role' => 'deny',
                'm_kasir_akses_temp_role' => 'deny',
                'm_kasir_akses_created_by' => 1
            ],
            [
                'm_kasir_akses_id' => '4',
                'm_kasir_akses_m_w_id' => 1,
                'm_kasir_akses_fitur' => 'lossbill_transaksi',
                'm_kasir_akses_default_role' => 'deny',
                'm_kasir_akses_temp_role' => 'deny',
                'm_kasir_akses_created_by' => 1
            ],
            [
                'm_kasir_akses_id' => '5',
                'm_kasir_akses_m_w_id' => 1,
                'm_kasir_akses_fitur' => 'refund',
                'm_kasir_akses_default_role' => 'deny',
                'm_kasir_akses_temp_role' => 'deny',
                'm_kasir_akses_created_by' => 1
            ],
        ]);
    }
}
