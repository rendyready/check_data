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
        Schema::create('m_jurnal_kas', function (Blueprint $table) {
            $table->id('m_jurnal_kas_id');
            $table->string('m_jurnal_kas_m_waroeng_id');
            $table->string('m_jurnal_kas_m_rekening_no_akun');
            $table->string('m_jurnal_kas_m_rekening_nama');
            $table->date('m_jurnal_kas_tanggal');
            $table->string('m_jurnal_kas_particul');
            $table->float('m_jurnal_kas_saldo');
            $table->string('m_jurnal_kas_no_bukti');
            $table->string('m_jurnal_kas');
            $table->string('m_jurnal_kas_user');
            $table->bigInteger('m_jurnal_kas_created_by');
            $table->bigInteger('m_jurnal_kas_updated_by')->nullable();
            $table->bigInteger('m_jurnal_kas_deleted_by')->nullable();
            $table->timestampTz('m_jurnal_kas_created_at')->useCurrent();
            $table->timestampTz('m_jurnal_kas_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_jurnal_kas_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_jurnal_kas');
    }
};
