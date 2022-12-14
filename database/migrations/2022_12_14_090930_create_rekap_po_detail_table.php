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
        Schema::create('rekap_po_detail', function (Blueprint $table) {
            $table->id('rekap_po_detal_id');
            $table->string('rekap_po_detal_rekap_po_code');
            $table->bigInteger('rekap_po_detail_m_produk_id');
            $table->string('rekap_po_detail_m_produk_code');
            $table->string('rekap_po_detail_m_produk_nama');
            $table->decimal('rekap_po_detail_qty',5,2);
            $table->string('rekap_po_detail_satuan')->nullable();
            $table->string('rekap_po_detail_catatan');
            $table->bigInteger('rekap_po_detail_created_by');
            $table->bigInteger('rekap_po_detail_updated_by')->nullable();
            $table->bigInteger('rekap_po_detail_deleted_by')->nullable();
            $table->timestampTz('rekap_po_detail_created_at')->useCurrent();
            $table->timestampTz('rekap_po_detail_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('rekap_po_detail_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_po_detail');
    }
};
