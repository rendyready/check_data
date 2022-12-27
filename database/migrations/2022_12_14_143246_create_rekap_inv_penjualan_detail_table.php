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
        Schema::create('rekap_inv_penjualan_detail', function (Blueprint $table) {
            $table->id('rekap_inv_penjualan_detail_id');
            $table->string('rekap_inv_penjualan_detail_rekap_inv_penjualan_code');
            $table->bigInteger('rekap_inv_penjualan_detail_m_produk_id');
            $table->string('rekap_inv_penjualan_detail_m_produk_code');
            $table->string('rekap_inv_penjualan_detail_m_produk_nama');
            $table->decimal('rekap_inv_penjualan_detail_qty',15,2);
            $table->string('rekap_inv_penjualan_detail_satuan')->nullable();
            $table->decimal('rekap_inv_penjualan_detail_harga',18,2);
            $table->decimal('rekap_inv_penjualan_detail_disc',5,2)->nullable();
            $table->decimal('rekap_inv_penjualan_detail_discrp',15,2)->nullable();
            $table->decimal('rekap_inv_penjualan_detail_subtot',9,2);
            $table->string('rekap_inv_penjualan_detail_catatan');
            $table->bigInteger('rekap_inv_penjualan_detail_created_by');
            $table->bigInteger('rekap_inv_penjualan_detail_updated_by')->nullable();
            $table->bigInteger('rekap_inv_penjualan_detail_deleted_by')->nullable();
            $table->timestampTz('rekap_inv_penjualan_detail_created_at')->useCurrent();
            $table->timestampTz('rekap_inv_penjualan_detail_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('rekap_inv_penjualan_detail_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_inv_penjualan_detail');
    }
};
