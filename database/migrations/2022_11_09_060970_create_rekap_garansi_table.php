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
        Schema::create('rekap_garansi', function (Blueprint $table) {
            $table->id('r_g_id');
            $table->bigInteger('r_g_sync_id')->nullable();
            $table->bigInteger('r_g_r_t_id');
            $table->date('r_g_tanggal');
            $table->smallInteger('r_g_shift');
            $table->time('r_g_jam');
            $table->string('r_g_nota_code');
            $table->bigInteger('r_g_m_produk_id');
            $table->string('r_g_m_produk_nama');
            $table->string('r_g_m_produk_cr')->default('');
            $table->string('r_g_m_produk_urut');
            $table->bigInteger('r_g_m_jenis_produk_id');
            $table->string('r_g_m_jenis_produk_nama');
            $table->decimal('r_g_m_produk_harga_nominal', 15);
            $table->integer('r_g_qty');
            $table->decimal('r_g_nominal', 15);
            $table->string('r_g_keterangan');
            $table->char('r_g_action', 5);
            $table->bigInteger('r_g_m_w_id');
            $table->string('r_g_m_w_nama');
            $table->bigInteger('r_g_m_area_id');
            $table->string('r_g_m_area_nama');
            $table->bigInteger('r_g_kasir_id');
            $table->string('r_g_kasir_nama');
            $table->char('r_g_status_sync', 1)->default('0');
            $table->bigInteger('r_g_created_by');
            $table->bigInteger('r_g_updated_by')->nullable();
            $table->bigInteger('r_g_deleted_by')->nullable();
            $table->timestampTz('r_g_created_at')->useCurrent();
            $table->timestampTz('r_g_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_g_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_garansi');
    }
};
