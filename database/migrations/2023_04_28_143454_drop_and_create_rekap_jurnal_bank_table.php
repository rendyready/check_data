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
        Schema::dropIfExists('m_jurnal_bank');

        Schema::create('rekap_jurnal_bank', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rekap_jurnal_bank_id')->unique();
            $table->string('rekap_jurnal_bank_m_waroeng_id');
            $table->string('rekap_jurnal_bank_m_rekening_no_akun');
            $table->string('rekap_jurnal_bank_m_rekening_nama');
            $table->date('rekap_jurnal_bank_tanggal');
            $table->string('rekap_jurnal_bank_particul');
            $table->float('rekap_jurnal_bank_saldo');
            $table->string('rekap_jurnal_bank_no_bukti');
            $table->string('rekap_jurnal_bank_kas');
            $table->string('rekap_jurnal_bank_user');
            $table->string('rekap_jurnal_bank_status_sync');
            $table->bigInteger('rekap_jurnal_bank_created_by');
            $table->bigInteger('rekap_jurnal_bank_updated_by')->nullable();
            $table->bigInteger('rekap_jurnal_bank_deleted_by')->nullable();
            $table->timestampTz('rekap_jurnal_bank_created_at')->useCurrent();
            $table->timestampTz('rekap_jurnal_bank_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('rekap_jurnal_bank_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_jurnal_bank');
    }
};
