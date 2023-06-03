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
        Schema::create('rph_detail_belanja', function (Blueprint $table) {
            $table->id();
            $table->string('rph_detail_belanja_id');
            $table->string('rph_detail_belanja_rph_code');
            $table->string('rph_detail_belanja_m_produk_code');
            $table->string('rph_detail_belanja_m_produk_nama');
            $table->string('rph_detail_belanja_qty_stok');
            $table->string('rph_detail_belanja_qty_keb');
            $table->string('rph_detail_belanja_qty_bb');
            $table->string('rph_detail_belanja_bagian');
            $table->string('rph_detail_belanja_status_sync')->default('send');
            $table->bigInteger('rph_detail_belanja_created_by');
            $table->bigInteger('rph_detail_belanja_updated_by')->nullable();
            $table->bigInteger('rph_detail_belanja_deleted_by')->nullable();
            $table->timestampTz('rph_detail_belanja_created_at')->useCurrent();
            $table->timestampTz('rph_detail_belanja_updated_at')->nullable()->useCurrentOnUpdate()->default(NULL);
            $table->timestampTz('rph_detail_belanja_deleted_at')->nullable()->default(NULL);
        });
        Schema::table('rph_detail_bb', function (Blueprint $table) {
            $table->decimal('rph_detail_bb_qty', 8, 2)->change();
        });
        Schema::dropIfExists('rph');
        Schema::create('rph', function (Blueprint $table) {
            $table->id('id');
            $table->string('rph_code');
            $table->date('rph_tgl');
            $table->string('rph_m_w_id');
            $table->string('rph_m_w_nama');
            $table->string('rph_order_status')->default('buka');
            $table->string('rph_status_sync')->default('send');
            $table->bigInteger('rph_created_by');
            $table->bigInteger('rph_updated_by')->nullable();
            $table->bigInteger('rph_deleted_by')->nullable();
            $table->timestampTz('rph_created_at')->useCurrent();
            $table->timestampTz('rph_updated_at')->nullable()->useCurrentOnUpdate()->default(NULL);
            $table->timestampTz('rph_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rph_detail_belanja');
        Schema::table('rph_detail_bb', function (Blueprint $table) {
            $table->decimal('rph_detail_bb_qty')->change();
        });
        Schema::dropIfExists('rph');
    }
};
