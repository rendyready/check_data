<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Helpers\JangkrikHelper;

class MKasirAksesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('m_kasir_akses')->truncate();
        DB::statement("TRUNCATE TABLE m_kasir_akses RESTART IDENTITY;");

        $waroeng = DB::table('m_w')->get();

        foreach ($waroeng as $key => $valmw) {
            DB::table('m_kasir_akses')->insert([
                [
                    'm_kasir_akses_id' => JangkrikHelper::getMasterId('m_kasir_akses'),
                    'm_kasir_akses_m_w_id' => $valmw->m_w_id,
                    'm_kasir_akses_fitur' => 'edit_menu',
                    'm_kasir_akses_default_role' => 'deny',
                    'm_kasir_akses_temp_role' => 'deny',
                    'm_kasir_akses_created_by' => 1
                ],
            ]);
            DB::table('m_kasir_akses')->insert([
                [
                    'm_kasir_akses_id' => JangkrikHelper::getMasterId('m_kasir_akses'),
                    'm_kasir_akses_m_w_id' => $valmw->m_w_id,
                    'm_kasir_akses_fitur' => 'cancel_menu',
                    'm_kasir_akses_default_role' => 'allow',
                    'm_kasir_akses_temp_role' => 'allow',
                    'm_kasir_akses_created_by' => 1
                ],
            ]);
            DB::table('m_kasir_akses')->insert([
                [
                    'm_kasir_akses_id' => JangkrikHelper::getMasterId('m_kasir_akses'),
                    'm_kasir_akses_m_w_id' => $valmw->m_w_id,
                    'm_kasir_akses_fitur' => 'cancel_transaksi',
                    'm_kasir_akses_default_role' => 'deny',
                    'm_kasir_akses_temp_role' => 'deny',
                    'm_kasir_akses_created_by' => 1
                ],
            ]);
            DB::table('m_kasir_akses')->insert([
                [
                    'm_kasir_akses_id' => JangkrikHelper::getMasterId('m_kasir_akses'),
                    'm_kasir_akses_m_w_id' => $valmw->m_w_id,
                    'm_kasir_akses_fitur' => 'lossbill_transaksi',
                    'm_kasir_akses_default_role' => 'deny',
                    'm_kasir_akses_temp_role' => 'deny',
                    'm_kasir_akses_created_by' => 1
                ],
            ]);
            DB::table('m_kasir_akses')->insert([
                [
                    'm_kasir_akses_id' => JangkrikHelper::getMasterId('m_kasir_akses'),
                    'm_kasir_akses_m_w_id' => $valmw->m_w_id,
                    'm_kasir_akses_fitur' => 'refund',
                    'm_kasir_akses_default_role' => 'deny',
                    'm_kasir_akses_temp_role' => 'deny',
                    'm_kasir_akses_created_by' => 1
                ],
            ]);
        }

    }
}
