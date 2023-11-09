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
        Schema::dropIfExists('m_jurnal_umum');

        Schema::create('rekap_jurnal_umum', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rekap_jurnal_umum_id')->unique();
            $table->string('rekap_jurnal_umum_m_waroeng_id');
            $table->string('rekap_jurnal_umum_m_rekening_no_akun');
            $table->string('rekap_jurnal_umum_m_rekening_nama');
            $table->date('rekap_jurnal_umum_tanggal');
            $table->string('rekap_jurnal_umum_particul');
            $table->float('rekap_jurnal_umum_debit');
            $table->float('rekap_jurnal_umum_kredit');
            $table->string('rekap_jurnal_umum_user');
            $table->string('rekap_jurnal_umum_no_bukti');
            $table->string('rekap_jurnal_umum_status_sync');
            $table->bigInteger('rekap_jurnal_umum_created_by');
            $table->bigInteger('rekap_jurnal_umum_updated_by')->nullable();
            $table->bigInteger('rekap_jurnal_umum_deleted_by')->nullable();
            $table->timestampTz('rekap_jurnal_umum_created_at')->useCurrent();
            $table->timestampTz('rekap_jurnal_umum_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('rekap_jurnal_umum_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_jurnal_umum');
    }
};
