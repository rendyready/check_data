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
        Schema::create('rekap_mutasi_modal', function (Blueprint $table) {
            $table->id('r_m_m_id');
            $table->bigInteger('r_m_m_sync_id')->nullable();
            $table->bigInteger('r_m_m_rekap_modal_id');
            $table->date('r_m_m_tanggal');
            $table->time('r_m_m_jam');
            $table->decimal('r_m_m_debit',10,2)->default(0);
            $table->decimal('r_m_m_kredit',10,2)->default(0);
            $table->string('r_m_m_keterangan');
            $table->bigInteger('r_m_m_m_w_id');
            $table->string('r_m_m_m_w_nama');
            $table->bigInteger('r_m_m_m_area_id');
            $table->string('r_m_m_m_area_nama');
            $table->char('r_m_m_status_sync', 1)->default('0');
            $table->bigInteger('r_m_m_created_by');
            $table->bigInteger('r_m_m_updated_by')->nullable();
            $table->bigInteger('r_m_m_deleted_by')->nullable();
            $table->timestampTz('r_m_m_created_at')->useCurrent();
            $table->timestampTz('r_m_m_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_m_m_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_mutasi_modal');
    }
};
