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
        Schema::create('rekap_sisa_detail', function (Blueprint $table) {
            $table->id('r_s_d_id');
            $table->bigInteger('r_s_d_r_s_id');
            $table->bigInteger('r_s_d_m_menu_id');
            $table->string('r_s_d_m_menu_code');
            $table->string('r_s_d_m_menu_nama');
            $table->string('r_s_d_m_menu_cr');
            $table->string('r_s_d_m_menu_urut');
            $table->bigInteger('r_s_d_m_menu_jenis_id');
            $table->string('r_s_d_m_menu_jenis_nama');
            $table->integer('r_s_d_qty');
            $table->char('r_s_d_status_sync', 1)->default('0');
            $table->timestampTz('r_s_d_created_by');
            $table->timestampTz('r_s_d_updated_by')->nullable();
            $table->timestampTz('r_s_d_created_at')->useCurrent();
            $table->timestampTz('r_s_d_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_s_d_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_sisa_detail');
    }
};
