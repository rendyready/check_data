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
        Schema::dropIfExists('m_gudang');
        Schema::create('m_gudang', function (Blueprint $table) {
            $table->id('id');
            $table->string('m_gudang_id')->unique();
            $table->string('m_gudang_code');
            $table->string('m_gudang_nama');
            $table->bigInteger('m_gudang_m_w_id');
            $table->string('m_gudang_m_w_nama');
            $table->string('m_gudang_status_sync')->default('send');
            $table->bigInteger('m_gudang_created_by');
            $table->bigInteger('m_gudang_updated_by')->nullable();
            $table->bigInteger('m_gudang_deleted_by')->nullable();
            $table->timestampTz('m_gudang_created_at')->useCurrent();
            $table->timestampTz('m_gudang_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_gudang_deleted_at')->nullable()->default(NULL);
        });

        Schema::dropIfExists('m_stok_detail');
        Schema::create('m_stok_detail', function (Blueprint $table) {
            $table->id('id');
            $table->string('m_stok_detail_id')->unique();
            $table->date('m_stok_detail_tgl');
            $table->string('m_stok_detail_m_produk_code');
            $table->string('m_stok_detail_m_produk_nama');
            $table->string('m_stok_detail_gudang_code');
            $table->bigInteger('m_stok_detail_satuan_id');
            $table->string('m_stok_detail_satuan')->nullable();
            $table->decimal('m_stok_detail_masuk',15,2)->nullable();
            $table->decimal('m_stok_detail_keluar',15,2)->nullable();
            $table->decimal('m_stok_detail_saldo',15,2);
            $table->decimal('m_stok_detail_so',15,2)->nullable();
            $table->decimal('m_stok_detail_hpp',18,2);
            $table->string('m_stok_detail_catatan');
            $table->string('m_stok_detail_status_sync')->default('send');
            $table->bigInteger('m_stok_detail_created_by');
            $table->bigInteger('m_stok_detail_updated_by')->nullable();
            $table->bigInteger('m_stok_detail_deleted_by')->nullable();
            $table->timestampTz('m_stok_detail_created_at')->useCurrent();
            $table->timestampTz('m_stok_detail_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_stok_detail_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_gudang');
        Schema::dropIfExists('m_stok_detail');
    }
};
