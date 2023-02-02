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
        Schema::create('m_rekening', function (Blueprint $table) {
            $table->id('m_rekening_id');
            $table->bigInteger('m_rekening_m_waroeng_id');
            $table->string('m_rekening_kategori');
            $table->bigInteger('m_rekening_no_akun');
            $table->string('m_rekening_nama');
            $table->integer('m_rekening_saldo');
            $table->bigInteger('m_rekening_created_by');
            $table->bigInteger('m_rekening_updated_by')->nullable();
            $table->bigInteger('m_rekening_deleted_by')->nullable();
            $table->timestampTz('m_rekening_created_at')->useCurrent();
            $table->timestampTz('m_rekening_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_rekening_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_rekening');
    }
};
