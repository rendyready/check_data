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
        Schema::create('rekap_tarikan_detail', function (Blueprint $table) {
            $table->id('r_t_d_id');
            $table->bigInteger('r_t_d_sync_id')->nullable();
            $table->bigInteger('r_t_d_r_t_k_id');
            $table->string('r_t_d_key');
            $table->string('r_t_d_value');
            $table->char('r_t_d_status_sync', 1)->default('0');
            $table->bigInteger('r_t_d_created_by');
            $table->bigInteger('r_t_d_updated_by')->nullable();
            $table->bigInteger('r_t_d_deleted_by')->nullable();
            $table->timestampTz('r_t_d_created_at')->useCurrent();
            $table->timestampTz('r_t_d_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_t_d_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_tarikan_detail');
    }
};
