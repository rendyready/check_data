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
        Schema::create('m_resep', function (Blueprint $table) {
            $table->id('id');
            $table->string('m_resep_code');
            $table->string('m_resep_m_produk_code');
            $table->string('m_resep_m_produk_nama');
            $table->string('m_resep_keterangan');
            $table->char('m_resep_status'); //aktif, non aktif
            $table->bigInteger('m_resep_created_by');
            $table->bigInteger('m_resep_updated_by')->nullable();
            $table->bigInteger('m_resep_deleted_by')->nullable();
            $table->timestampTz('m_resep_created_at')->useCurrent();
            $table->timestampTz('m_resep_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_resep_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_resep');
    }
};
