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
        Schema::create('rekap_po', function (Blueprint $table) {
            $table->id('rekap_po_id');
            $table->string('rekap_po_code'); //id user+ urutan
            $table->date('rekap_po_tgl');
            $table->bigInteger('rekap_po_supplier_id');
            $table->string('rekap_po_supplier_nama');
            $table->string('rekap_po_supplier_telp')->nullable();
            $table->string('rekap_po_supplier_alamat')->nullable();
            $table->bigInteger('rekap_po_m_w_id');
            $table->bigInteger('rekap_po_created_by');
            $table->bigInteger('rekap_po_updated_by')->nullable();
            $table->bigInteger('rekap_po_deleted_by')->nullable();
            $table->timestampTz('rekap_po_created_at')->useCurrent();
            $table->timestampTz('rekap_po_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('rekap_po_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_po');
    }
};
