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
        Schema::create('rekap_buka_laci', function (Blueprint $table) {
            $table->id('id'); 
            $table->string('r_b_l_id')->unique(); 
            // $table->bigInteger('r_b_l_sync_id')->nullable();
            $table->string('r_b_l_rekap_modal_id');
            $table->date('r_b_l_tanggal');
            $table->integer('r_b_l_qty');
            $table->string('r_b_l_keterangan');
            $table->unsignedBigInteger('r_b_l_m_w_id');
            $table->string('r_b_l_m_w_code')->nullable();
            $table->string('r_b_l_m_w_nama');
            $table->unsignedBigInteger('r_b_l_m_area_id');
            $table->string('r_b_l_m_area_code')->nullable();
            $table->string('r_b_l_m_area_nama');
            $table->string('r_b_l_status_sync', 20)->default('send');
            $table->bigInteger('r_b_l_created_by');
            $table->bigInteger('r_b_l_deleted_by')->nullable();
            $table->bigInteger('r_b_l_updated_by')->nullable();
            $table->timestampTz('r_b_l_created_at')->useCurrent();
            $table->timestampTz('r_b_l_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_b_l_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_buka_laci');
    }
};
