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
        Schema::create('m_sub_jenis_produk', function (Blueprint $table) {
            $table->id('m_sub_jenis_produk_id');
            $table->string('m_sub_jenis_produk_nama');
            $table->bigInteger('m_sub_jenis_produk_m_jenis_produk_id');
            $table->bigInteger('m_sub_jenis_produk_created_by');
            $table->timestampTz('m_sub_jenis_produk_created_at')->useCurrent();
            $table->bigInteger('m_sub_jenis_produk_updated_by')->nullable();
            $table->timestampTz('m_sub_jenis_produk_updated_at')->nullable()->useCurrentOnUpdate()->default(NULL);
            $table->timestampTz('m_sub_jenis_produk_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_sub_jenis_produk');
    }
};
