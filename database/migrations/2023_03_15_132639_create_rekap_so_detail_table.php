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
        Schema::create('rekap_so_detail', function (Blueprint $table) {
            $table->id('id');
            $table->string('rekap_so_detail_id');
            $table->string('rekap_so_detail_m_gudang_code');
            $table->string('rekap_so_detail_m_produk_code');
            $table->string('rekap_so_detail_m_produk_nama');
            $table->string('rekap_so_detail_qty');
            $table->string('rekap_so_detail_satuan');
            $table->string('rekap_so_detail_qty_riil');
            $table->bigInteger('rekap_so_detail_created_by');
            $table->bigInteger('rekap_so_detail_updated_by')->nullable();
            $table->bigInteger('rekap_so_detail_deleted_by')->nullable();
            $table->timestampTz('rekap_so_detail_created_at')->useCurrent();
            $table->timestampTz('rekap_so_detail_updated_at')->nullable()->useCurrentOnUpdate()->default(NULL);
            $table->timestampTz('rekap_so_detail_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_so_detail');
    }
};
