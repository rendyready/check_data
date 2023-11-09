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
        Schema::create('rekap_rusak_detail', function (Blueprint $table) {
            $table->id('id');
            $table->string('rekap_rusak_detail_id');
            $table->string('rekap_rusak_detail_rekap_rusak_code');
            $table->string('rekap_rusak_detail_gudang_code');
            $table->string('rekap_rusak_detail_m_produk_code');
            $table->string('rekap_rusak_detail_m_produk_nama');
            $table->decimal('rekap_rusak_detail_qty',6,2);
            $table->decimal('rekap_rusak_detail_hpp',10,2);
            $table->decimal('rekap_rusak_detail_sub_total',12,2);
            $table->string('rekap_rusak_detail_satuan')->nullable();
            $table->string('rekap_rusak_detail_catatan');
            $table->bigInteger('rekap_rusak_detail_created_by');
            $table->bigInteger('rekap_rusak_detail_updated_by')->nullable();
            $table->bigInteger('rekap_rusak_detail_deleted_by')->nullable();
            $table->timestampTz('rekap_rusak_detail_created_at')->useCurrent();
            $table->timestampTz('rekap_rusak_detail_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('rekap_rusak_detail_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_rusak_detail');
    }
};
