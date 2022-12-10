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
        Schema::create('m_supplier', function (Blueprint $table) {
            $table->id('m_supplier_id');
            $table->string('m_supplier_code');
            $table->string('m_supplier_nama',255);
            $table->string('m_supplier_alamat',255);
            $table->string('m_supplier_kota',100);
            $table->string('m_supplier_telp',25);
            $table->string('m_supplier_ket',255);
            $table->string('m_supplier_rek');
            $table->string('m_supplier_rek_nama');
            $table->string('m_supplier_bank_nama');
            $table->decimal('m_supplier_saldo_awal',8,2);
            $table->bigInteger('m_supplier_created_by');
            $table->bigInteger('m_supplier_updated_by')->nullable();
            $table->bigInteger('m_supplier_deleted_by')->nullable();
            $table->timestampTz('m_supplier_created_at')->useCurrent();
            $table->timestampTz('m_supplier_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_supplier_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_supplier');
    }
};
