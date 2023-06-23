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
        // $table[28] = 'm_resep';
        // $table[29] = 'm_resep_detail';
        // $table[30] = 'm_supplier';
        // $table[32] = 'm_stok';
        // $table[33] = 'm_stok_detail';
        // $table[34] = 'm_gudang';
        // $table[35] = 'm_gudang_nama';

        foreach ($table as $key => $valTable) {
            $fieldName = $valTable."_client_target";
            Schema::table($valTable, function (Blueprint $table) use ($fieldName) {
                $table->text($fieldName)->default(DB::raw('list_waroeng()'))->nullable();
            });
        }
        Schema::table('roles', function (Blueprint $table) {
            $table->text('roles_client_target')->default(DB::raw('list_waroeng()'))->nullable();
        });
        Schema::table('permissions', function (Blueprint $table) {
            $table->text('permissions_client_target')->default(DB::raw('list_waroeng()'))->nullable();
        });
        Schema::table('role_has_permissions', function (Blueprint $table) {
            $table->text('r_h_p_client_target')->default(DB::raw('list_waroeng()'))->nullable();
        });
        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->text('m_h_p_client_target')->default(DB::raw('list_waroeng()'))->nullable();
        });
        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->text('m_h_r_client_target')->default(DB::raw('list_waroeng()'))->nullable();
        });
        Schema::table('m_transaksi_tipe', function (Blueprint $table) {
            $table->text('m_t_t_client_target')->default(DB::raw('list_waroeng()'))->nullable();
        });

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
            Schema::table($valTable, function (Blueprint $table) use ($valTable) {
                $table->dropColumn([$valTable.'_client_target']);
            });
        }
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn(['roles_client_target']);
        });
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn(['permissions_client_target']);
        });
        Schema::table('role_has_permissions', function (Blueprint $table) {
            $table->dropColumn(['r_h_p_client_target']);
        });
        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->dropColumn(['m_h_p_client_target']);
        });
        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->dropColumn(['m_h_r_client_target']);
        });
        Schema::table('m_transaksi_tipe', function (Blueprint $table) {
            $table->dropColumn(['m_t_t_client_target']);
        });
    }
};
