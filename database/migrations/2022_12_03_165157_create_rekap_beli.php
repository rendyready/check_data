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
            $table->id('rekap_beli_id');
            $table->string('rekap_beli_code'); //id user+ urutan
            $table->string('rekap_beli_code_nota');
            $table->string('rekap_beli_tgl');
            $table->string('rekap_beli_jth_tmp');
            $table->bigInteger('rekap_beli_sp_id');
            $table->string('rekap_beli_sp_nama');
            $table->string('rekap_beli_telp');
            $table->string('rekap_beli_alamat');
            $table->string('rekap_beli_m_w_id');
            $table->string('rekap_beli_disc');
            $table->string('rekap_beli_disc_rp');
            $table->string('rekap_beli_ppn');
            $table->string('rekap_beli_ppn_rp');
            $table->string('rekap_beli_ongkir');
            $table->string('rekap_beli_terbayar');
            $table->string('rekap_beli_tersisa');
            $table->string('rekap_beli_tot_nom');
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
