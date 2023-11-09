<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResetMasterSequenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table[1] = 'users';
        $table[2] = 'm_area';
        $table[3] = 'm_pajak';
        $table[4] = 'm_sc';
        $table[5] = 'm_w_jenis';
        $table[6] = 'm_w';
        $table[7] = 'm_footer';
        $table[8] = 'm_jenis_nota';
        $table[9] = 'm_menu_harga';
        $table[10] = 'm_jenis_produk';
        $table[11] = 'm_klasifikasi_produk';
        $table[12] = 'm_plot_produksi';
        $table[13] = 'm_satuan';
        $table[14] = 'm_produk';
        $table[15] = 'm_sub_jenis_produk';
        $table[16] = 'config_sub_jenis_produk';
        $table[17] = 'm_kasir_akses';
        $table[18] = 'm_meja_jenis';
        $table[19] = 'm_meja';
        $table[20] = 'm_modal_tipe';
        $table[21] = 'm_payment_method';
        // $table[22] = 'app_setting';
        // $table[23] = 'm_karyawan';
        // $table[24] = 'm_jabatan';
        // $table[25] = 'history_pendidikan';
        // $table[26] = 'history_jabatan';
        // $table[27] = 'm_group_produk';
        // $table[28] = 'm_level_jabatan';
        $table[29] = 'm_stok';
        $table[30] = 'm_transaksi_tipe';

        foreach ($table as $key => $valTable) {

            #Get Last Increment Used
            $maxId = DB::select("SELECT MAX(id) FROM {$valTable};")[0]->max;

            #GET Current Increment of table (Recomended method)
            $currentId = DB::select("SELECT last_value FROM {$valTable}_id_seq;")[0]->last_value;
            if (!empty($maxId) && $currentId >= 1) {
                if ($maxId != $currentId) {
                    DB::select("SELECT setval('{$valTable}_id_seq', {$maxId});");
                }
            }
        }
    }
}
