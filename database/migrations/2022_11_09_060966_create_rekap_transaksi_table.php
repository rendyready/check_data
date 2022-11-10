<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekap_transaksi', function (Blueprint $table) {
            $table->id('r_t_id');
            $table->bigInteger('r_t_m_jenis_nota_id');
            $table->string('r_t_m_jenis_nota_nama');
            $table->string('r_t_nota_code');
            $table->smallInteger('r_t_shift');
            $table->date('r_t_tanggal');
            $table->time('r_t_jam')->nullable();
            $table->dateTime('r_t_jam_input');
            $table->dateTime('r_t_jam_order')->nullable();
            $table->dateTime('r_t_jam_bayar');
            $table->integer('r_t_durasi_input')->nullable()->default(0);
            $table->integer('r_t_durasi_produksi')->nullable()->default(0);
            $table->integer('r_t_durasi_saji')->nullable()->default(0);
            $table->integer('r_t_durasi_pelayanan')->nullable();
            $table->integer('r_t_durasi_kunjungan');
            $table->bigInteger('r_t_config_meja_id');
            $table->string('r_t_config_meja_nama');
            $table->integer('r_t_m_meja_jenis_space');
            $table->string('r_t_bigbos');
            $table->bigInteger('r_t_m_area_id');
            $table->string('r_t_m_area_nama');
            $table->bigInteger('r_t_m_w_id');
            $table->string('r_t_m_w_nama');
            $table->decimal('r_t_nominal_menu', 15)->default(0);
            $table->decimal('r_t_nominal_pajak_menu', 15)->default(0);
            $table->decimal('r_t_nominal_non_menu', 15)->default(0);
            $table->decimal('r_t_nominal_pajak_non_menu', 15)->default(0);
            $table->decimal('r_t_nominal_lain', 15)->default(0);
            $table->decimal('r_t_nominal_pajak_lain', 15)->default(0);
            $table->decimal('r_t_nominal', 15)->default(0);
            $table->decimal('r_t_nominal_pajak', 15)->default(0);
            $table->decimal('r_t_nominal_plus_pajak', 15)->default(0);
            $table->decimal('r_t_nominal_potongan', 15)->default(0);
            $table->decimal('r_t_nominal_diskon', 15)->default(0);
            $table->decimal('r_t_nominal_voucher', 15)->default(0);
            $table->decimal('r_t_nominal_sc', 15)->default(0);
            $table->decimal('r_t_nominal_pembulatan', 15)->default(0);
            $table->decimal('r_t_nominal_total_bayar', 15)->default(0);
            $table->decimal('r_t_nominal_total_uang', 15)->default(0);
            $table->decimal('r_t_nominal_void', 15)->default(0);
            $table->decimal('r_t_nominal_void_pajak', 15)->default(0);
            $table->decimal('r_t_nominal_void_sc', 15)->default(0);
            $table->decimal('r_t_nominal_pembulatan_void', 15)->default(0);
            $table->decimal('r_t_nominal_free_kembalian_void', 15)->default(0);
            $table->integer('r_t_void_counter')->nullable()->default(0);
            $table->decimal('r_t_nominal_kembalian', 15)->default(0);
            $table->decimal('r_t_nominal_free_kembalian', 15)->default(0);
            $table->decimal('r_t_nominal_total_kembalian', 15)->default(0);
            $table->decimal('r_t_nominal_tarik_tunai', 15)->default(0);
            $table->decimal('r_t_pajak', 3)->default(0);
            $table->decimal('r_t_diskon', 3)->default(0);
            $table->decimal('r_t_sc', 3)->default(0);
            $table->bigInteger('r_t_m_t_t_id');
            $table->string('r_t_m_t_t_name');
            $table->decimal('r_t_m_t_t_profit_price', 3)->default(0);
            $table->decimal('r_t_m_t_t_profit_in', 3)->default(0);
            $table->decimal('r_t_m_t_t_profit_out', 3)->default(0);
            $table->char('r_t_tax_status', 1)->nullable()->default('1');
            $table->string('r_t_status');
            $table->string('r_t_catatan')->nullable();
            $table->string('r_t_kasir_id');
            $table->string('r_t_kasir_nama');
            $table->string('r_t_ops_id')->nullable();
            $table->string('r_t_ops_nama')->nullable();
            $table->char('r_t_status_sync', 1)->default('0');
            $table->bigInteger('r_t_created_by');
            $table->bigInteger('r_t_updated_by')->nullable();
            $table->timestampTz('r_t_created_at')->useCurrent();
            $table->timestampTz('r_t_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_t_deleted_at')->nullable()->default(NULL);

            // $table->index(['r_t_nota_code', 'r_t_tanggal', 'r_t_jam', 'r_t_m_w_id'], 'mrt_counter_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_transaksi');
    }
};
