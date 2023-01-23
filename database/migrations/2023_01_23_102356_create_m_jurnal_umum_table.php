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
        Schema::create('m_jurnal_umum', function (Blueprint $table) {
            $table->id('m_jurnal_umum_id');
            $table->bigInteger('m_jurnal_umum_m_waroeng_id');
            $table->bigInteger('m_jurnal_umum_m_rekening_no_akun');
            $table->string('m_jurnal_umum_m_rekening_nama');
            $table->date('m_jurnal_umum_tanggal');
            $table->string('m_jurnal_umum_particul');
            $table->float('m_jurnal_umum_debit');
            $table->float('m_jurnal_umum_kredit');
            $table->string('m_jurnal_umum_user');
            $table->string('m_jurnal_umum_no_bukti');
            $table->bigInteger('m_jurnal_umum_created_by');
            $table->bigInteger('m_jurnal_umum_updated_by')->nullable();
            $table->bigInteger('m_jurnal_umum_deleted_by')->nullable();
            $table->timestampTz('m_jurnal_umum_created_at')->useCurrent();
            $table->timestampTz('m_jurnal_umum_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_jurnal_umum_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_jurnal_umum');
    }
};
