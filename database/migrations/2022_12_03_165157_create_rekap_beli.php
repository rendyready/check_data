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
        Schema::create('rekap_beli', function (Blueprint $table) {
            $table->id('id');
            $table->string('rekap_beli_id');
            $table->string('rekap_beli_code'); //id user+ urutan
            $table->string('rekap_beli_code_nota')->nullable(); //code nota dari supplier jika ada
            $table->date('rekap_beli_tgl');
            $table->string('rekap_beli_jth_tmp');
            $table->string('rekap_beli_supplier_code');
            $table->string('rekap_beli_gudang_code');
            $table->string('rekap_beli_supplier_nama');
            $table->string('rekap_beli_supplier_telp')->nullable();
            $table->string('rekap_beli_supplier_alamat')->nullable();
            $table->bigInteger('rekap_beli_m_w_id');
            $table->string('rekap_beli_waroeng');
            $table->decimal('rekap_beli_disc',8,2)->nullable();
            $table->decimal('rekap_beli_disc_rp')->nullable();
            $table->decimal('rekap_beli_ppn',8,2)->nullable();
            $table->decimal('rekap_beli_ppn_rp',12,2)->nullable();
            $table->decimal('rekap_beli_ongkir',12,2)->nullable();
            $table->decimal('rekap_beli_terbayar',16,2);
            $table->decimal('rekap_beli_tersisa',16,2);
            $table->decimal('rekap_beli_tot_nom',16,2);
            $table->string('rekap_beli_ket')->nullable();
            $table->bigInteger('rekap_beli_created_by');
            $table->bigInteger('rekap_beli_updated_by')->nullable();
            $table->bigInteger('rekap_beli_deleted_by')->nullable();
            $table->timestampTz('rekap_beli_created_at')->useCurrent();
            $table->timestampTz('rekap_beli_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('rekap_beli_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_beli');
    }
};
