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
            $table->id('r_b_l_id'); 
            $table->bigInteger('r_b_l_sync_id')->nullable();
            $table->date('r_b_l_tanggal');
            $table->smallInteger('r_b_l_shift');
            $table->time('r_b_l_jam');
            $table->string('r_b_l_keterangan');
            $table->bigInteger('r_b_l_m_w_id');
            $table->string('r_b_l_m_w_nama');
            $table->bigInteger('r_b_l_kasir_id');
            $table->string('r_b_l_kasir_nama');
            $table->char('r_b_l_status_sync', 1)->default('0');
            $table->bigInteger('r_b_l_created_by');
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
