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
        Schema::create('rekap_lost_bill', function (Blueprint $table) {
            $table->id('r_l_b_id');
            $table->bigInteger('r_l_b_sync_id')->nullable();
            $table->bigInteger('r_l_b_r_t_id');
            $table->date('r_l_b_tanggal');
            $table->smallInteger('r_l_b_shift');
            $table->time('r_l_b_jam');
            $table->string('r_l_b_nota_code');
            $table->bigInteger('r_l_b_m_produk_id');
            $table->string('r_l_b_m_produk_nama');
            $table->string('r_l_b_m_produk_cr')->default('');
            $table->string('r_l_b_m_produk_urut');
            $table->bigInteger('r_l_b_m_jenis_produk_id');
            $table->string('r_l_b_m_jenis_produk_nama');
            $table->decimal('r_l_b_m_produk_harga_nominal', 15);
            $table->integer('r_l_b_qty');
            $table->decimal('r_l_b_nominal', 15);
            $table->string('r_l_b_keterangan');
            $table->bigInteger('r_l_b_m_w_id');
            $table->string('r_l_b_m_w_nama');
            $table->bigInteger('r_l_b_m_area_id');
            $table->string('r_l_b_m_area_nama');
            $table->bigInteger('r_l_b_kasir_id');
            $table->string('r_l_b_kasir_nama');
            $table->char('r_l_b_status_sync', 1)->default('0');
            $table->bigInteger('r_l_b_ops_id');
            $table->string('r_l_b_ops_nama');
            $table->bigInteger('r_l_b_created_by');
            $table->bigInteger('r_l_b_updated_by')->nullable();
            $table->timestampTz('r_l_b_created_at')->useCurrent();
            $table->timestampTz('r_l_b_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_l_b_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_lost_bill');
    }
};
