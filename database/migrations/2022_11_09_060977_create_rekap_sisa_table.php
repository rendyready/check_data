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
        Schema::create('rekap_sisa', function (Blueprint $table) {
            $table->id('r_s_id');
            $table->bigInteger('r_s_m_w_id');
            $table->string('r_s_m_w_nama');
            $table->bigInteger('r_s_m_area_id');
            $table->string('r_s_m_area_nama');
            $table->dateTime('r_s_tanggal');
            $table->char('r_s_status_sync', 1)->default('0');
            $table->bigInteger('r_s_created_by');
            $table->bigInteger('r_s_updated_by')->nullable();
            $table->timestampTz('r_s_created_at')->useCurrent();
            $table->timestampTz('r_s_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_s_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_sisa');
    }
};
