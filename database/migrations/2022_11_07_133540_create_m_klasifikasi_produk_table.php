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
        Schema::create('m_klasifikasi_produk', function (Blueprint $table) {
            $table->id('id');
            $table->string('m_klasifikasi_produk_id')->unique();
            $table->string('m_klasifikasi_produk_nama');
            $table->string('m_klasifikasi_produk_prefix');
            $table->integer('m_klasifikasi_produk_last_id')->default(1);
            $table->bigInteger('m_klasifikasi_produk_created_by');
            $table->bigInteger('m_klasifikasi_produk_updated_by')->nullable();
            $table->bigInteger('m_klasifikasi_produk_deleted_by')->nullable();
            $table->timestampTz('m_klasifikasi_produk_created_at')->useCurrent();
            $table->timestampTz('m_klasifikasi_produk_updated_at')->nullable()->useCurrentOnUpdate()->default(NULL);
            $table->timestampTz('m_klasifikasi_produk_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_klasifikasi_produk');
    }
};
