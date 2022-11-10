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
        Schema::create('rekap_menu_habis', function (Blueprint $table) {
            $table->id('r_m_h_id');
            $table->bigInteger('r_m_h_m_area_id');
            $table->string('r_m_h_m_area_nama');
            $table->bigInteger('r_m_h_m_w_id');
            $table->string('r_m_h_m_w_nama');
            $table->bigInteger('r_m_h_m_menu_id');
            $table->string('r_m_h_m_menu_nama');
            $table->string('r_m_h_m_menu_cr');
            $table->string('r_m_h_m_menu_urut');
            $table->bigInteger('r_m_h_m_menu_jenis_id');
            $table->string('r_m_h_m_menu_jenis_nama');
            $table->string('r_m_h_m_menu_code');
            $table->date('r_m_h_tanggal');
            $table->string('r_m_h_shift');
            $table->time('r_m_h_waktu')->nullable();
            $table->char('r_m_h_status_sync', 1)->default('0');
            $table->bigInteger('r_m_h_created_by');
            $table->bigInteger('r_m_h_updated_by')->nullable();
            $table->timestampTz('r_m_h_created_at')->useCurrent();
            $table->timestampTz('r_m_h_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_m_h_deleted_at')->nullable()->default(NULL);

            // $table->index(['r_m_h_tanggal', 'r_m_h_m_menu_jenis_id', 'r_m_h_waktu'], 'mrmh_counter_idx');s
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_menu_habis');
    }
};
