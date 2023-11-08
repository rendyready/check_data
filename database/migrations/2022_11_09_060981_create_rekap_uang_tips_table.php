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
            $table->id('id');
            $table->string('r_u_t_id')->unique();
            // $table->bigInteger('r_u_t_sync_id')->nullable();
            $table->string('r_u_t_rekap_modal_id');
            $table->date('r_u_t_tanggal');
            $table->decimal('r_u_t_nominal',8,2);
            $table->unsignedBigInteger('r_u_t_m_w_id');
            $table->string('r_u_t_m_w_code')->nullable();
            $table->string('r_u_t_m_w_nama')->nullable();
            $table->unsignedBigInteger('r_u_t_m_area_id');
            $table->string('r_u_t_m_area_code')->nullable();
            $table->string('r_u_t_m_area_nama')->nullable();
            $table->string('r_u_t_keterangan');
            $table->string('r_u_t_status_sync', 20)->default('send');
            $table->bigInteger('r_u_t_created_by');
            $table->bigInteger('r_u_t_updated_by')->nullable();
            $table->bigInteger('r_u_t_deleted_by')->nullable();
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
