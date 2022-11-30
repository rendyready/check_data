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
        Schema::create('rekap_uang_tips', function (Blueprint $table) {
            $table->id('r_u_t_id');
            $table->bigInteger('r_u_t_sync_id')->nullable();
            $table->date('r_u_t_tanggal');
            $table->smallInteger('r_u_t_shift');
            $table->time('r_u_t_jam');
            $table->bigInteger('r_u_t_m_karyawan_id');
            $table->string('r_u_t_m_karyawan_nama');
            $table->decimal('r_u_t_debit');
            $table->decimal('r_u_t_kredit');
            $table->bigInteger('r_u_t_m_w_id');
            $table->string('r_u_t_m_w_nama');
            $table->bigInteger('r_u_t_m_area_id');
            $table->string('r_u_t_m_area_nama');
            $table->bigInteger('r_u_t_kasir_id');
            $table->string('r_u_t_kasir_nama');
            $table->string('r_u_t_keterangan');
            $table->char('r_u_t_status_sync', 1)->default('0');
            $table->bigInteger('r_u_t_created_by');
            $table->bigInteger('r_u_t_updated_by')->nullable();
            $table->timestampTz('r_u_t_created_at')->useCurrent();
            $table->timestampTz('r_u_t_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_u_t_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_uang_tips');
    }
};
