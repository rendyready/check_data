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
            $table->id('r_p_t_id');
            $table->bigInteger('r_p_t_r_t_id');
            $table->string('r_p_t_type');
            $table->decimal('r_p_t_nominal', 15);
            $table->string('r_p_t_vendor')->nullable();
            $table->char('r_p_t_status_sync', 1)->default('0');
            $table->bigInteger('r_p_t_created_by');
            $table->bigInteger('r_p_t_updated_by')->nullable();
            $table->timestampTz('r_p_t_created_at')->useCurrent();
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
