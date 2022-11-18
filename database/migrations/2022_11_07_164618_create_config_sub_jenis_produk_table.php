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
        Schema::create('config_sub_jenis_produk', function (Blueprint $table) {
            $table->id('config_sub_jenis_produk_id');
            $table->bigInteger('config_sub_jenis_produk_m_produk_id');
            $table->bigInteger('config_sub_jenis_produk_m_kategori_id');
            $table->bigInteger('config_sub_jenis_produk_created_by');
            $table->timestampTz('config_sub_jenis_produk_created_at')->useCurrent();
            $table->timestampTz('config_sub_jenis_produk_updated_at')->nullable()->useCurrentOnUpdate()->default(NULL);
            $table->timestampTz('config_sub_jenis_produk_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_sub_jenis_produk');
    }
};
