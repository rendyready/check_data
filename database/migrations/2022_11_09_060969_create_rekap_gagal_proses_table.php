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
        Schema::create('rekap_gagal_proses', function (Blueprint $table) {
            $table->id('r_g_p_id');
            $table->bigInteger('r_g_p_sync_id')->nullable();
            $table->date('r_g_p_tanggal');
            $table->smallInteger('r_g_p_shift');
            $table->time('r_g_p_jam');
            $table->string('r_g_p_m_produk_code');
            $table->bigInteger('r_g_p_m_produk_id');
            $table->string('r_g_p_m_produk_nama');
            $table->bigInteger('r_g_p_m_jenis_produk_id');
            $table->string('r_g_p_m_jenis_produk_nama');
            $table->string('r_g_p_m_produk_urut');
            $table->decimal('r_g_p_m_produk_harga_nominal', 15);
            $table->integer('r_g_p_qty');
            $table->decimal('r_g_p_nominal', 15);
            $table->string('r_g_p_keterangan');
            $table->bigInteger('r_g_p_m_w_id');
            $table->string('r_g_p_m_w_nama');
            $table->bigInteger('r_g_p_m_area_id');
            $table->string('r_g_p_m_area_nama');
            $table->bigInteger('r_g_p_kasir_id');
            $table->string('r_g_p_kasir_nama');
            $table->char('r_g_p_status_sync', 1)->default('0');
            $table->bigInteger('r_g_p_created_by');
            $table->bigInteger('r_g_p_updated_by')->nullable();
            $table->bigInteger('r_g_p_deleted_by')->nullable();
            $table->timestampTz('r_g_p_created_at')->useCurrent();
            $table->timestampTz('r_g_p_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_g_p_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_gagal_proses');
    }
};
