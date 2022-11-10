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
        Schema::create('rekap_pre_void', function (Blueprint $table) {
            $table->id('r_p_v_id');
            $table->bigInteger('r_p_v_r_t_id');
            $table->date('r_p_v_tanggal');
            $table->smallInteger('r_p_v_shift');
            $table->time('r_p_v_jam');
            $table->string('r_p_v_nota_code');
            $table->bigInteger('r_p_v_m_menu_id');
            $table->string('r_p_v_m_menu_nama');
            $table->string('r_p_v_m_menu_cr')->default('');
            $table->string('r_p_v_m_menu_urut');
            $table->bigInteger('r_p_v_m_menu_jenis_id');
            $table->string('r_p_v_m_menu_jenis_nama');
            $table->decimal('r_p_v_m_menu_harga_nominal', 15);
            $table->integer('r_p_v_qty');
            $table->decimal('r_p_v_nominal', 15);
            $table->string('r_p_v_keterangan');
            $table->bigInteger('r_p_v_m_w_id');
            $table->string('r_p_v_m_w_nama');
            $table->bigInteger('r_p_v_m_area_id');
            $table->string('r_p_v_m_area_nama');
            $table->bigInteger('r_p_v_kasir_id');
            $table->string('r_p_v_kasir_nama');
            $table->char('r_p_v_status_sync', 1)->default('0');
            $table->bigInteger('r_p_v_created_by');
            $table->bigInteger('r_p_v_updated_by')->nullable();
            $table->timestampTz('r_p_v_created_at')->useCurrent();
            $table->timestampTz('r_p_v_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_p_v_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_pre_void');
    }
};
