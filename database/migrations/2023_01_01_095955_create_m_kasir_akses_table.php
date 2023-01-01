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
        Schema::create('m_kasir_akses', function (Blueprint $table) {
            $table->id('m_kasir_akses_id');
            $table->bigInteger('m_kasir_akses_m_w_id');
            $table->string('m_kasir_akses_fitur')->comment('lostbill,cancel menu,cancel transaksi, cancel menu after bill, void');
            $table->string('m_kasir_akses_default_role')->comment('open,close');
            $table->string('m_kasir_akses_temp_role')->comment('open,close');
            $table->bigInteger('m_kasir_akses_created_by');
            $table->bigInteger('m_kasir_akses_updated_by')->nullable();
            $table->bigInteger('m_kasir_akses_deleted_by')->nullable();
            $table->timestampTz('m_kasir_akses_created_at')->useCurrent();
            $table->timestampTz('m_kasir_akses_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_kasir_akses_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_kasir_akses');
    }
};
