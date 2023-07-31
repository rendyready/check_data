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
        Schema::dropIfExists('m_link_akuntansi');

        Schema::create('m_link_akuntansi', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('m_link_akuntansi_id');
            $table->string('m_link_akuntansi_nama');
            $table->string('m_link_akuntansi_m_rekening_no_akun')->nullable();
            $table->json('m_link_akuntansi_field_sync')->nullable();
            $table->bigInteger('m_link_akuntansi_created_by');
            $table->bigInteger('m_link_akuntansi_updated_by')->nullable();
            $table->bigInteger('m_link_akuntansi_deleted_by')->nullable();
            $table->timestampTz('m_link_akuntansi_created_at')->useCurrent();
            $table->timestampTz('m_link_akuntansi_updated_at')->useCurrentOnUpdate()->nullable()->default(null);
            $table->timestampTz('m_link_akuntansi_deleted_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_link_akuntansi');
    }
};
