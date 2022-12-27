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
        Schema::create('m_stok_mutasi', function (Blueprint $table) {
            $table->id('m_stok_mutasi_id');
            $table->bigInteger('m_stok_mutasi_m_produk_id');
            $table->string('m_stok_mutasi_m_produk_nama');
            $table->string('m_stok_mutasi_satuan');
            $table->decimal('m_stok_mutasi_masuk',15,2)->nullable();
            $table->decimal('m_stok_mutasi_keluar',15,2)->nullable();
            $table->decimal('m_stok_mutasi_saldo',15,2);
            $table->decimal('m_stok_mutasi_so',15,2)->nullable();
            $table->decimal('m_stok_mutasi_hpp',18,2);
            $table->decimal('m_stok_mutasi_nilai',18,2);
            $table->string('m_stok_mutasi_catatan');
            $table->bigInteger('m_stok_mutasi_m_w_id');
            $table->string('m_stok_mutasi_gudang');
            $table->bigInteger('m_stok_mutasi_created_by');
            $table->bigInteger('m_stok_mutasi_updated_by')->nullable();
            $table->bigInteger('m_stok_mutasi_deleted_by')->nullable();
            $table->timestampTz('m_stok_mutasi_created_at')->useCurrent();
            $table->timestampTz('m_stok_mutasi_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_stok_mutasi_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_stok_mutasi');
    }
};
