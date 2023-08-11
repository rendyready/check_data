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
        Schema::dropIfExists('config_sync');
        Schema::create('config_sync', function (Blueprint $table) {
            $table->id('config_sync_id');
            $table->string('config_sync_table_name');
            $table->string('config_sync_table_tipe')->comment('master,transaksi,config');
            $table->string('config_sync_status')->default('on')->comment('on/off');
            $table->string('config_sync_for')->nullable()->comment('pusat/area/waroeng');
            $table->string('config_sync_tipe')->nullable()->comment('send/get');
            $table->unsignedInteger('config_sync_limit')->default(100);
            $table->string('config_sync_truncate')->default('off')->comment('on/off');
            $table->string('config_sync_sequence')->default('off')->comment('on/off');
            $table->string('config_sync_field_pkey')->nullable();
            $table->string('config_sync_field_status')->nullable();
            $table->string('config_sync_field_validate1')->nullable();
            $table->string('config_sync_field_validate2')->nullable();
            $table->string('config_sync_field_validate3')->nullable();
            $table->string('config_sync_field_validate4')->nullable();
            $table->timestampTz('config_sync_created_at')->useCurrent();
            $table->timestampTz('config_sync_updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_sync');
        Schema::create('config_sync', function (Blueprint $table) {
            $table->id('config_sync_id');
            $table->string('config_sync_table_name');
            $table->string('config_sync_table_tipe')->comment('master,transaksi,config');
            $table->string('config_sync_status')->default('aktif')->comment('aktif/tidak');
            $table->unsignedInteger('config_sync_limit')->default(100);
            $table->string('config_sync_truncate')->default('tidak')->comment('aktif/tidak');
            $table->string('config_sync_field_status')->nullable();
            $table->string('config_sync_field_validate1')->nullable();
            $table->string('config_sync_field_validate2')->nullable();
            $table->string('config_sync_field_validate3')->nullable();
            $table->string('config_sync_field_validate4')->nullable();
            $table->timestampTz('config_sync_created_at')->useCurrent();
            $table->timestampTz('config_sync_updated_at')->nullable()->useCurrentOnUpdate();
        });
    }
};
