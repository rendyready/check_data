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
        Schema::create('rekap_void', function (Blueprint $table) {
            $table->id('r_v_id');
            $table->bigInteger('r_v_r_t_id');
            $table->date('r_v_tanggal');
            $table->smallInteger('r_v_shift');
            $table->time('r_v_jam');
            $table->string('r_v_nota_code');
            $table->bigInteger('r_v_m_produk_id');
            $table->string('r_v_m_produk_nama');
            $table->string('r_v_m_menu_cr');
            $table->string('r_v_m_menu_urut');
            $table->bigInteger('r_v_m_jenis_produk_id');
            $table->string('r_v_m_jenis_produk_nama');
            $table->decimal('r_v_m_menu_harga_nominal', 15);
            $table->integer('r_v_qty');
            $table->decimal('r_v_nominal', 15);
            $table->char('r_v_tax_status', 1)->nullable()->default('1');
            $table->char('r_v_sc_status', 1)->nullable()->default('0');
            $table->string('r_v_keterangan');
            $table->bigInteger('r_v_m_w_id');
            $table->string('r_v_m_w_nama');
            $table->bigInteger('r_v_m_area_id');
            $table->string('r_v_m_area_nama');
            $table->bigInteger('r_v_kasir_id');
            $table->string('r_v_kasir_nama');
            $table->char('r_v_status_sync', 1)->default('0');
            $table->bigInteger('r_v_created_by');
            $table->bigInteger('r_v_updated_by')->nullable();
            $table->timestampTz('r_v_created_at')->useCurrent();
            $table->timestampTz('r_v_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_v_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_void');
    }
};
