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
        Schema::create('rekap_transaksi_detail', function (Blueprint $table) {
            $table->id('r_t_detail_id');
            $table->bigInteger('r_t_detail_sync_id')->nullable();
            $table->bigInteger('r_t_detail_r_t_id');
            $table->bigInteger('r_t_detail_m_produk_id');
            // $table->string('r_t_detail_m_produk_nama');
            $table->string('r_t_detail_custom')->nullable();
            $table->decimal('r_t_detail_price', 8,2);
            $table->integer('r_t_detail_qty');
            $table->decimal('r_t_detail_nominal', 15,2)->default(0);
            $table->decimal('r_t_detail_nominal_pajak', 15,2)->default(0);
            $table->decimal('r_t_detail_nominal_sc', 15,2)->default(0);
            $table->decimal('r_t_detail_nominal_sharing_profit_in', 15,2)->default(0);
            $table->decimal('r_t_detail_nominal_sharing_profit_out', 15,2)->default(0);
            $table->char('r_t_detail_status_sync', 10)->default('0');
            $table->bigInteger('r_t_detail_created_by');
            $table->bigInteger('r_t_detail_updated_by')->nullable();
            $table->bigInteger('r_t_detail_deleted_by')->nullable();
            $table->timestampTz('r_t_detail_created_at')->useCurrent();
            $table->timestampTz('r_t_detail_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_t_detail_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_transaksi_detail');
    }
};
