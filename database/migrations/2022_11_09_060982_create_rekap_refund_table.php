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
        Schema::create('rekap_refund', function (Blueprint $table) {
            $table->id('r_r_id');
            $table->bigInteger('r_r_sync_id')->nullable();
            $table->bigInteger('r_r_r_t_id');
            $table->bigInteger('r_r_m_produk_id');
            $table->string('r_r_m_produk_nama')->nullable();
            $table->decimal('r_r_price', 8,2);
            $table->integer('r_r_qty');
            $table->decimal('r_r_nominal', 15,2);
            $table->decimal('r_r_nominal_pajak', 15,2)->default(0);
            $table->decimal('r_r_nominal_sc', 15,2)->default(0);
            $table->decimal('r_r_nominal_sharing_profit_in', 15,2)->default(0);
            $table->decimal('r_r_nominal_sharing_profit_out', 15,2)->default(0);
            $table->string('r_r_keterangan')->nullable();
            $table->char('r_r_status_sync', 10)->default('0');
            $table->bigInteger('r_r_approved_by')->nullable();
            $table->bigInteger('r_r_created_by');
            $table->bigInteger('r_r_updated_by')->nullable();
            $table->bigInteger('r_r_deleted_by')->nullable();
            $table->timestampTz('r_r_created_at')->useCurrent();
            $table->timestampTz('r_r_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_r_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_refund');
    }
};
