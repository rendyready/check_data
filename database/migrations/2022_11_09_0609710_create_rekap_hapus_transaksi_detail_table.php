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
        Schema::create('rekap_hapus_transaksi_detail', function (Blueprint $table) {
            $table->id('id');
            $table->string('r_h_t_detail_id')->unique();
            // $table->bigInteger('r_h_t_detail_sync_id')->nullable();
            $table->string('r_h_t_detail_r_h_t_id');
            $table->unsignedBigInteger('r_h_t_detail_m_produk_id');
            $table->string('r_h_t_detail_m_produk_code')->nullable();
            $table->string('r_h_t_detail_m_produk_nama')->nullable();
            $table->integer('r_h_t_detail_qty');
            $table->decimal('r_h_t_detail_reguler_price', 8,2)->default(0);
            $table->decimal('r_h_t_detail_price', 8,2)->default(0);
            $table->decimal('r_h_t_detail_nominal', 15,2)->default(0);
            $table->decimal('r_h_t_detail_nominal_pajak', 15,2)->default(0);
            $table->decimal('r_h_t_detail_nominal_sc', 15,2)->default(0);
            $table->decimal('r_h_t_detail_nominal_sharing_profit_in', 15,2)->default(0);
            $table->decimal('r_h_t_detail_nominal_sharing_profit_out', 15,2)->default(0);
            $table->string('r_h_t_detail_status_sync', 20)->default('send');
            $table->bigInteger('r_h_t_detail_created_by');
            $table->bigInteger('r_h_t_detail_updated_by')->nullable();
            $table->bigInteger('r_h_t_detail_deleted_by')->nullable();
            $table->timestampTz('r_h_t_detail_created_at')->useCurrent();
            $table->timestampTz('r_h_t_detail_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_h_t_detail_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_hapus_transaksi_detail');
    }
};