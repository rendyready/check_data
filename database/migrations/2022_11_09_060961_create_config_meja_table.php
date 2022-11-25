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
        Schema::create('config_meja', function (Blueprint $table) {
            $table->id('config_meja_id');
            $table->string('config_meja_nama');
            $table->bigInteger('config_meja_m_meja_jenis_id');
            $table->bigInteger('config_meja_m_w_id');
            $table->string('config_meja_type');
            $table->char('config_meja_status_sync', 1)->default('1');
            $table->bigInteger('config_meja_created_by');
            $table->timestampTz('config_meja_created_at')->useCurrent();
            $table->bigInteger('config_meja_updated_by')->nullable();
            $table->timestampTz('config_meja_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('config_meja_deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_meja');
    }
};
