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
        Schema::create('rekap_tf_gudang', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('rekap_tf_gudang_id');
            $table->string('rekap_tf_gudang_code');
            $table->string('rekap_tf_gudang_asal_code'); 
            $table->string('rekap_tf_gudang_tujuan_code');
            $table->bigInteger('rekap_tf_gudang_m_w_id');
            $table->datetime('rekap_tf_gudang_tgl_keluar');
            $table->datetime('rekap_tf_gudang_tgl_terima')->nullable();
            $table->string('rekap_tf_gudang_m_produk_code');
            $table->string('rekap_tf_gudang_m_produk_nama');
            $table->decimal('rekap_tf_gudang_qty_keluar',6,2);
            $table->string('rekap_tf_gudang_satuan_keluar')->nullable();
            $table->decimal('rekap_tf_gudang_qty_terima',6,2)->nullable();
            $table->string('rekap_tf_gudang_satuan_terima')->nullable();
            $table->decimal('rekap_tf_gudang_hpp',10,2);
            $table->decimal('rekap_tf_gudang_sub_total',12,2);
            $table->bigInteger('rekap_tf_gudang_created_by');
            $table->bigInteger('rekap_tf_gudang_updated_by')->nullable();
            $table->bigInteger('rekap_tf_gudang_deleted_by')->nullable();
            $table->timestampTz('rekap_tf_gudang_created_at')->useCurrent();
            $table->timestampTz('rekap_tf_gudang_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('rekap_tf_gudang_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_tf_gudang');
    }
};
