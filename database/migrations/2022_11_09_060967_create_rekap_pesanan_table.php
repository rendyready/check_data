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
        Schema::create('rekap_pesanan', function (Blueprint $table) {
            $table->id('r_p_id');
            $table->bigInteger('r_p_sync_id')->nullable();
            $table->bigInteger('r_p_m_produk_id');
            $table->string('r_p_m_produk_code')->nullable();
            $table->string('r_p_m_produk_nama');
            $table->string('r_p_m_produk_cr');
            $table->string('r_p_m_produk_urut');
            $table->decimal('r_p_m_produk_harga_nominal', 15);
            $table->bigInteger('r_p_m_r_t_id');
            $table->date('r_p_tanggal');
            $table->time('r_p_jam');
            $table->bigInteger('r_p_m_jenis_produk_id');
            $table->string('r_p_m_jenis_produk_nama');
            $table->string('r_p_custom');
            $table->integer('r_p_qty');
            $table->dateTime('r_p_jam_input');
            $table->dateTime('r_p_jam_order')->nullable();
            $table->dateTime('r_p_jam_tata')->nullable();
            $table->dateTime('r_p_jam_saji')->nullable();
            $table->integer('r_p_durasi_produksi')->nullable();
            $table->integer('r_p_durasi_saji')->nullable();
            $table->integer('r_p_durasi_pelayanan')->nullable();
            $table->decimal('r_p_nominal', 15);
            $table->string('r_p_status');
            $table->char('r_p_tax_status', 1)->nullable()->default('1');
            $table->char('r_p_sc_status', 1)->nullable()->default('0');
            $table->char('r_p_status_sync', 1)->default('0');
            $table->bigInteger('r_p_created_by');
            $table->bigInteger('r_p_updated_by')->nullable();
            $table->bigInteger('r_p_deleted_by')->nullable();
            $table->timestampTz('r_p_created_at')->useCurrent();
            $table->timestampTz('r_p_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_p_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_pesanan');
    }
};
