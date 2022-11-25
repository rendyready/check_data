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
        Schema::create('rekap_tarikan_kasir', function (Blueprint $table) {
            $table->id('r_t_k_id');
            $table->date('r_t_k_tanggal');
            $table->smallInteger('r_t_k_shift');
            $table->bigInteger('r_t_k_m_w_id');
            $table->string('r_t_k_m_w_nama');
            $table->bigInteger('r_t_k_m_area_id');
            $table->string('r_t_k_m_area_nama');
            $table->bigInteger('r_t_k_kasir_id');
            $table->string('r_t_k_kasir_nama');
            $table->char('r_t_k_status_sync', 1)->default('0');
            $table->bigInteger('r_t_k_created_by');
            $table->bigInteger('r_t_k_updated_by')->nullable();
            $table->timestampTz('r_t_k_created_at')->useCurrent();
            $table->timestampTz('r_t_k_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_t_k_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_tarikan_kasir');
    }
};
