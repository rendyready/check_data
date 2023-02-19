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
        Schema::create('m_produk', function (Blueprint $table) {
            $table->id('id');
            $table->string('m_produk_id')->unique();
            $table->string('m_produk_code')->nullable();
            $table->string('m_produk_nama');
            $table->string('m_produk_urut')->nullable();
            $table->string('m_produk_cr')->nullable();
            $table->string('m_produk_status')->default('1');
            $table->string('m_produk_tax')->default('1');
            $table->string('m_produk_sc')->default('1');
            $table->string('m_produk_m_jenis_produk_id')->nullable();
            $table->string('m_produk_utama_m_satuan_id');
            $table->string('m_produk_isi_m_satuan_id')->nullable();
            $table->integer('m_produk_qty_isi')->default(1);
            $table->string('m_produk_m_plot_produksi_id')->nullable();
            $table->string('m_produk_m_klasifikasi_produk_id')->nullable();
            $table->string('m_produk_jual')->default('tidak'); // ya = dijual di CR, tidak = tidak dijual di CR
            $table->string('m_produk_scp');
            $table->string('m_produk_hpp');
            $table->bigInteger('m_produk_created_by');
            $table->bigInteger('m_produk_updated_by')->nullable();
            $table->bigInteger('m_produk_deleted_by')->nullable();
            $table->timestampTz('m_produk_created_at')->useCurrent();
            $table->timestampTz('m_produk_updated_at')->nullable()->useCurrentOnUpdate()->default(NULL);
            $table->timestampTz('m_produk_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_produk');
    }
};
