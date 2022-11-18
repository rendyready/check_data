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
        Schema::create('m_rekap_void', function (Blueprint $table) {
            $table->id('m_r_v_id');
            $table->bigInteger('m_r_v_r_t_id');
            $table->date('m_r_v_tanggal');
            $table->smallInteger('m_r_v_shift');
            $table->time('m_r_v_jam');
            $table->string('m_r_v_nota_code');
            $table->bigInteger('m_r_v_m_produk_id');
            $table->string('m_r_v_m_produk_nama');
            $table->string('m_r_v_m_menu_cr');
            $table->string('m_r_v_m_menu_urut');
            $table->bigInteger('m_r_v_m_jenis_produk_id');
            $table->string('m_r_v_m_jenis_produk_nama');
            $table->decimal('m_r_v_m_menu_harga_nominal', 15);
            $table->integer('m_r_v_qty');
            $table->decimal('m_r_v_nominal', 15);
            $table->char('m_r_v_tax_status', 1)->nullable()->default('1');
            $table->char('m_r_v_sc_status', 1)->nullable()->default('0');
            $table->string('m_r_v_keterangan');
            $table->bigInteger('m_r_v_m_w_id');
            $table->string('m_r_v_m_w_nama');
            $table->bigInteger('m_r_v_m_area_id');
            $table->string('m_r_v_m_area_nama');
            $table->bigInteger('m_r_v_kasir_id');
            $table->string('m_r_v_kasir_nama');
            $table->char('m_r_v_status_sync', 1)->default('0');
            $table->bigInteger('m_r_v_created_by');
            $table->bigInteger('m_r_v_updated_by')->nullable();
            $table->timestampTz('m_r_v_created_at')->useCurrent();
            $table->timestampTz('m_r_v_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_r_v_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_rekap_void');
    }
};
