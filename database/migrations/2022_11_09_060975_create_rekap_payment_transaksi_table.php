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
        Schema::create('rekap_payment_transaksi', function (Blueprint $table) {
            $table->id('id');
            $table->string('r_p_t_id')->unique();
            // $table->bigInteger('r_p_t_sync_id')->nullable();
            $table->string('r_p_t_r_t_id');
            $table->string('r_p_t_m_payment_method_id');
            $table->decimal('r_p_t_nominal', 15,2);
            $table->char('r_p_t_status_sync', 10)->default('0');
            $table->bigInteger('r_p_t_created_by');
            $table->bigInteger('r_p_t_updated_by')->nullable();
            $table->timestampTz('r_p_t_deleted_by')->nullable();
            $table->timestampTz('r_p_t_created_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_p_t_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_p_t_deleted_at')->nullable()->default(NUll);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_payment_transaksi');
    }
};
