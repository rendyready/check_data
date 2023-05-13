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
        Schema::create('config_get_data', function (Blueprint $table) {
            $table->id('config_get_data_id');
            $table->string('config_get_data_table_name');
            $table->string('config_get_data_table_tipe')->comment('master,transaksi,config');
            $table->string('config_get_data_status')->default('on')->comment('on/off');
            $table->unsignedInteger('config_get_data_limit')->default(0);
            $table->string('config_get_data_truncate')->default('off')->comment('on/off');
            $table->string('config_get_data_sequence')->default('off')->comment('on/off');
            $table->string('config_get_data_field_status')->nullable();
            $table->string('config_get_data_field_validate1')->nullable();
            $table->string('config_get_data_field_validate2')->nullable();
            $table->string('config_get_data_field_validate3')->nullable();
            $table->string('config_get_data_field_validate4')->nullable();
            $table->timestampTz('config_get_data_created_at')->useCurrent();
            $table->timestampTz('config_get_data_updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_get_data');
    }
};
