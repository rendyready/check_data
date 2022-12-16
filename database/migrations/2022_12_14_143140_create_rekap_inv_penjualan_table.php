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
        Schema::create('rekap_inv_penjualan', function (Blueprint $table) {
            $table->id('rekap_inv_penjualan_id');
            $table->string('rekap_inv_penjualan_code'); //id user+ urutan
            $table->date('rekap_inv_penjualan_tgl');
            $table->string('rekap_inv_penjualan_jth_tmp');
            $table->bigInteger('rekap_inv_penjualan_supplier_id');
            $table->string('rekap_inv_penjualan_supplier_nama');
            $table->string('rekap_inv_penjualan_supplier_telp')->nullable();
            $table->string('rekap_inv_penjualan_supplier_alamat')->nullable();
            $table->bigInteger('rekap_inv_penjualan_m_w_id');
            $table->decimal('rekap_inv_penjualan_disc',8,2)->nullable();
            $table->decimal('rekap_inv_penjualan_disc_rp')->nullable();
            $table->decimal('rekap_inv_penjualan_ppn',8,2)->nullable();
            $table->decimal('rekap_inv_penjualan_ppn_rp')->nullable();
            $table->string('rekap_inv_penjualan_ongkir')->nullable();
            $table->string('rekap_inv_penjualan_tot_nom');
            $table->string('rekap_inv_penjualan_terbayar');
            $table->string('rekap_inv_penjualan_tersisa');
            $table->bigInteger('rekap_inv_penjualan_created_by');
            $table->bigInteger('rekap_inv_penjualan_updated_by')->nullable();
            $table->bigInteger('rekap_inv_penjualan_deleted_by')->nullable();
            $table->timestampTz('rekap_inv_penjualan_created_at')->useCurrent();
            $table->timestampTz('rekap_inv_penjualan_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('rekap_inv_penjualan_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_inv_penjualan');
    }
};
