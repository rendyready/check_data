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
        Schema::create('m_meja', function (Blueprint $table) {
            $table->id('m_meja_id');
            $table->string('m_meja_nama');
            $table->bigInteger('m_meja_m_meja_jenis_id');
            $table->bigInteger('m_meja_m_w_id');
            $table->string('m_meja_type');
            $table->char('m_meja_status_sync', 1)->default('1');
            $table->bigInteger('m_meja_created_by');
            $table->bigInteger('m_meja_updated_by')->nullable();
            $table->bigInteger('m_meja_deleted_by')->nullable();
            $table->timestampTz('m_meja_created_at')->useCurrent();
            $table->timestampTz('m_meja_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_meja_deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_meja');
    }
};
