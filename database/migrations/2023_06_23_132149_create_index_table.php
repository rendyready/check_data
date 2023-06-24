<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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
        $table[22] = 'app_setting';
        $table[23] = 'm_karyawan';
        $table[24] = 'm_jabatan';
        $table[25] = 'history_pendidikan';
        $table[26] = 'history_jabatan';
        $table[27] = 'm_group_produk';
        $table[28] = 'm_level_jabatan';

        foreach ($table as $key => $valTable) {
            DB::statement("CREATE INDEX {$valTable}_target_idx_1 ON {$valTable} USING GIN (to_tsvector('english', {$valTable}_client_target));");
        }

        DB::statement("CREATE INDEX roles_target_idx_1 ON roles USING GIN (to_tsvector('english', roles_client_target));");
        DB::statement("CREATE INDEX permissions_target_idx_1 ON permissions USING GIN (to_tsvector('english', permissions_client_target));");
        DB::statement("CREATE INDEX role_has_permissions_target_idx_1 ON role_has_permissions USING GIN (to_tsvector('english', r_h_p_client_target));");
        DB::statement("CREATE INDEX model_has_permissions_target_idx_1 ON model_has_permissions USING GIN (to_tsvector('english', m_h_p_client_target));");
        DB::statement("CREATE INDEX model_has_roles_target_idx_1 ON model_has_roles USING GIN (to_tsvector('english', m_h_r_client_target));");
        DB::statement("CREATE INDEX m_transaksi_tipe_target_idx_1 ON m_transaksi_tipe USING GIN (to_tsvector('english', m_t_t_client_target));");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
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
        $table[22] = 'app_setting';
        $table[23] = 'm_karyawan';
        $table[24] = 'm_jabatan';
        $table[25] = 'history_pendidikan';
        $table[26] = 'history_jabatan';
        $table[27] = 'm_group_produk';
        $table[28] = 'm_level_jabatan';

        foreach ($table as $key => $valTable) {
            DB::statement("DROP INDEX {$valTable}_target_idx_1;");

        }
        DB::statement("DROP INDEX roles_target_idx_1;");
        DB::statement("DROP INDEX permissions_target_idx_1;");
        DB::statement("DROP INDEX role_has_permissions_target_idx_1;");
        DB::statement("DROP INDEX model_has_permissions_target_idx_1;");
        DB::statement("DROP INDEX model_has_roles_target_idx_1;");
        DB::statement("DROP INDEX m_transaksi_tipe_target_idx_1;");
    }
};
