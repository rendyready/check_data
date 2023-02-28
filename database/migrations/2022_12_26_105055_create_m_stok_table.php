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
        Schema::create('m_stok', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('m_stok_id');
            $table->string('m_stok_m_produk_code');
            $table->string('m_stok_produk_nama');
            $table->string('m_stok_gudang_code');
            $table->string('m_stok_waroeng');
            $table->bigInteger('m_stok_satuan_id')->nullable();
            $table->string('m_stok_satuan')->nullable();
            $table->decimal('m_stok_awal')->default(0);
            $table->decimal('m_stok_masuk',18,2)->default(0);
            $table->decimal('m_stok_keluar',18,2)->default(0);
            $table->decimal('m_stok_saldo',18,2)->default(0);
            $table->decimal('m_stok_hpp',18,2)->default(0);
            $table->decimal('m_stok_rusak',18,2)->default(0);
            $table->decimal('m_stok_lelang',18,2)->default(0);
            $table->string('m_stok_isi')->default(1);
            $table->decimal('m_stok_konversi',12,2)->default(1);
            $table->bigInteger('m_stok_created_by');
            $table->bigInteger('m_stok_updated_by')->nullable();
            $table->bigInteger('m_stok_deleted_by')->nullable();
            $table->timestampTz('m_stok_created_at')->useCurrent();
            $table->timestampTz('m_stok_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_stok_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_stok');
    }
};
