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
        Schema::create('rekap_beli_detail', function (Blueprint $table) {
            $table->id('rekap_beli_detal_id');
            $table->bigInteger('rekap_beli_detal_rekap_beli_id');
            $table->bigInteger('rekap_beli_detail_m_produk_id');
            $table->string('rekap_beli_detail_m_produk_code');
            $table->string('rekap_beli_detail_m_produk_nama');
            $table->decimal('rekap_beli_detail_qty',5,2);
            $table->string('rekap_beli_detail_satuan')->nullable();
            $table->decimal('rekap_beli_detail_harga',10,2);
            $table->decimal('rekap_beli_detail_disc',8,2)->nullable();
            $table->decimal('rekap_beli_detail_discrp')->nullable();
            $table->decimal('rekap_beli_detail_subtot',9,2);
            $table->string('rekap_beli_detail_catatan');
            $table->bigInteger('rekap_beli_detail_created_by');
            $table->bigInteger('rekap_beli_detail_updated_by')->nullable();
            $table->bigInteger('rekap_beli_detail_deleted_by')->nullable();
            $table->timestampTz('rekap_beli_detail_created_at')->useCurrent();
            $table->timestampTz('rekap_beli_detail_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('rekap_beli_detail_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_beli_detail');
    }
};
