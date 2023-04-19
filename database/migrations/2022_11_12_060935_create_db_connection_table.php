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
        Schema::create('db_con', function (Blueprint $table) {
            $table->id('db_con_id');
            $table->string('db_con_m_w_id')->nullable();
            $table->string('db_con_m_area_id')->nullable();
            $table->string('db_con_location')->comment('pusat/area/waroeng');
            $table->string('db_con_location_name')->comment('nama waroeng');
            $table->string('db_con_data_status')->comment('source/destination');
            $table->string('db_con_sync_status')->default('aktif')->comment('aktif/tidak');
            $table->string('db_con_network_status')->nullable()->comment('connect/disconnect');
            $table->string('db_con_schema_status')->nullable()->comment('expired/latest');
            $table->string('db_con_driver')->default('pgsql');
            $table->string('db_con_host');
            $table->string('db_con_port')->default('5432');
            $table->string('db_con_dbname');
            $table->string('db_con_username');
            $table->string('db_con_password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('db_con');
    }
};
