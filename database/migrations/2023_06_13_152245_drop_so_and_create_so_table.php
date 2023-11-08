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
        Schema::dropIfExists('rekap_so');
        Schema::create('rekap_so', function (Blueprint $table) {
            $table->id('id');
            $table->string('rekap_so_id')->unique();
            $table->date('rekap_so_tgl');
            $table->string('rekap_so_m_gudang_code');
            $table->bigInteger('rekap_so_m_klasifikasi_produk_id');
            $table->string('rekap_so_m_w_code');
            $table->string('rekap_so_m_w_nama');
            $table->string('rekap_so_status_sync')->default('send');
            $table->bigInteger('rekap_so_created_by');
            $table->bigInteger('rekap_so_updated_by')->nullable();
            $table->bigInteger('rekap_so_deleted_by')->nullable();
            $table->timestampTz('rekap_so_created_at')->useCurrent();
            $table->timestampTz('rekap_so_updated_at')->nullable()->useCurrentOnUpdate()->default(null);
            $table->timestampTz('rekap_so_deleted_at')->nullable()->default(null);
        });
        Schema::dropIfExists('rekap_so_detail');
        Schema::create('rekap_so_detail', function (Blueprint $table) {
            $table->id('id');
            $table->string('rekap_so_detail_id')->unique();
            $table->string('rekap_so_detail_rekap_so_id');
            $table->string('rekap_so_detail_m_gudang_code');
            $table->string('rekap_so_detail_m_produk_code');
            $table->string('rekap_so_detail_m_produk_nama');
            $table->string('rekap_so_detail_qty');
            $table->string('rekap_so_detail_satuan');
            $table->string('rekap_so_detail_qty_riil');
            $table->string('rekap_so_detail_status_sync')->default('send');
            $table->bigInteger('rekap_so_detail_created_by');
            $table->bigInteger('rekap_so_detail_updated_by')->nullable();
            $table->bigInteger('rekap_so_detail_deleted_by')->nullable();
            $table->timestampTz('rekap_so_detail_created_at')->useCurrent();
            $table->timestampTz('rekap_so_detail_updated_at')->nullable()->useCurrentOnUpdate()->default(null);
            $table->timestampTz('rekap_so_detail_deleted_at')->nullable()->default(null);
        });
        Schema::dropIfExists('rph_detail_belanja');
        Schema::create('rph_detail_belanja', function (Blueprint $table) {
            $table->id();
            $table->string('rph_detail_belanja_id')->unique();
            $table->string('rph_detail_belanja_rph_code');
            $table->string('rph_detail_belanja_m_produk_code');
            $table->string('rph_detail_belanja_m_produk_nama');
            $table->string('rph_detail_belanja_qty_stok');
            $table->string('rph_detail_belanja_qty_keb');
            $table->string('rph_detail_belanja_qty_bb_order');
            $table->string('rph_detail_belanja_satuan_keb');
            $table->string('rph_detail_belanja_satuan_order');
            $table->string('rph_detail_belanja_bagian');
            $table->string('rph_detail_belanja_status_sync')->default('send');
            $table->bigInteger('rph_detail_belanja_created_by');
            $table->bigInteger('rph_detail_belanja_updated_by')->nullable();
            $table->bigInteger('rph_detail_belanja_deleted_by')->nullable();
            $table->timestampTz('rph_detail_belanja_created_at')->useCurrent();
            $table->timestampTz('rph_detail_belanja_updated_at')->nullable()->useCurrentOnUpdate()->default(null);
            $table->timestampTz('rph_detail_belanja_deleted_at')->nullable()->default(null);
        });
        Schema::dropIfExists('rekap_rusak');
        Schema::create('rekap_rusak', function (Blueprint $table) {
            $table->id('id');
            $table->string('rekap_rusak_id')->unique();
            $table->date('rekap_rusak_tgl');
            $table->bigInteger('rekap_rusak_m_w_id');
            $table->string('rekap_rusak_m_w_nama');
            $table->string('rekap_rusak_m_gudang_code');
            $table->string('rekap_rusak_status_sync')->default('send');
            $table->bigInteger('rekap_rusak_created_by');
            $table->bigInteger('rekap_rusak_updated_by')->nullable();
            $table->bigInteger('rekap_rusak_deleted_by')->nullable();
            $table->timestampTz('rekap_rusak_created_at')->useCurrent();
            $table->timestampTz('rekap_rusak_updated_at')->useCurrentOnUpdate()->nullable()->default(null);
            $table->timestampTz('rekap_rusak_deleted_at')->nullable()->default(null);
        });
        Schema::dropIfExists('rekap_rusak_detail');
        Schema::create('rekap_rusak_detail', function (Blueprint $table) {
            $table->id('id');
            $table->string('rekap_rusak_detail_id');
            $table->string('rekap_rusak_detail_rekap_rusak_id');
            $table->string('rekap_rusak_detail_gudang_code');
            $table->string('rekap_rusak_detail_m_produk_code');
            $table->string('rekap_rusak_detail_m_produk_nama');
            $table->decimal('rekap_rusak_detail_qty', 6, 2);
            $table->decimal('rekap_rusak_detail_hpp', 10, 2);
            $table->decimal('rekap_rusak_detail_sub_total', 12, 2);
            $table->string('rekap_rusak_detail_satuan')->nullable();
            $table->string('rekap_rusak_detail_catatan');
            $table->string('rekap_rusak_detail_status_sync')->default('send');
            $table->bigInteger('rekap_rusak_detail_created_by');
            $table->bigInteger('rekap_rusak_detail_updated_by')->nullable();
            $table->bigInteger('rekap_rusak_detail_deleted_by')->nullable();
            $table->timestampTz('rekap_rusak_detail_created_at')->useCurrent();
            $table->timestampTz('rekap_rusak_detail_updated_at')->useCurrentOnUpdate()->nullable()->default(null);
            $table->timestampTz('rekap_rusak_detail_deleted_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_so');
        Schema::dropIfExists('rekap_so_detail');
        Schema::dropIfExists('rph_detail_belanja');
        Schema::dropIfExists('rekap_rusak');
        Schema::dropIfExists('rekap_rusak_detail');
    }
};
