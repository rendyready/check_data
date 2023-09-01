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
        Schema::create('log_version', function (Blueprint $table) {
            $table->id('log_version_id');
            $table->string('log_version_m_w_id');
            $table->string('log_version_m_w_nama');
            $table->string('log_version_sipedas')->nullable();
            $table->string('log_version_cr55')->nullable();
            $table->string('log_version_api')->nullable();
            $table->string('log_version_cronjob')->nullable();
            $table->timestampTz('log_version_datetime')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_version');
    }
};
