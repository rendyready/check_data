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
        Schema::create('m_meja_jenis', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('m_meja_jenis_id');
            $table->string('m_meja_jenis_nama');
            $table->integer('m_meja_jenis_space');
            $table->char('m_meja_jenis_status', 1)->nullable()->default('0');
            $table->bigInteger('m_meja_jenis_created_by');
            $table->bigInteger('m_meja_jenis_updated_by')->nullable();
            $table->bigInteger('m_meja_jenis_deleted_by')->nullable();
            $table->timestampTz('m_meja_jenis_created_at')->useCurrent();
            $table->timestampTz('m_meja_jenis_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_meja_jenis_deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_meja_jenis');
    }
};
