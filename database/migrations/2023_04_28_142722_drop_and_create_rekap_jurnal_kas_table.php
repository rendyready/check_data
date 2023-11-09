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
        // Drop the old table
        Schema::dropIfExists('m_jurnal_kas');

        Schema::create('rekap_jurnal_kas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rekap_jurnal_kas_id')->unique();
            $table->string('rekap_jurnal_kas_m_waroeng_id');
            $table->string('rekap_jurnal_kas_m_rekening_no_akun');
            $table->string('rekap_jurnal_kas_m_rekening_nama');
            $table->date('rekap_jurnal_kas_tanggal');
            $table->string('rekap_jurnal_kas_particul');
            $table->float('rekap_jurnal_kas_saldo');
            $table->string('rekap_jurnal_kas_no_bukti');
            $table->string('rekap_jurnal_kas');
            $table->string('rekap_jurnal_kas_user');
            $table->string('rekap_jurnal_kas_status_sync');
            $table->bigInteger('rekap_jurnal_kas_created_by');
            $table->bigInteger('rekap_jurnal_kas_updated_by')->nullable();
            $table->bigInteger('rekap_jurnal_kas_deleted_by')->nullable();
            $table->timestampTz('rekap_jurnal_kas_created_at')->useCurrent();
            $table->timestampTz('rekap_jurnal_kas_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('rekap_jurnal_kas_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_jurnal_kas');
    }
};
