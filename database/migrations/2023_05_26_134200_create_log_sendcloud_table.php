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
        Schema::create('log_sendcloud', function (Blueprint $table) {
            $table->id('log_sendcloud_id');
            $table->string('log_sendcloud_table');
            $table->string('log_sendcloud_last_id');
            $table->string('log_sendcloud_note')->nullable();
            $table->timestampTz('log_sendcloud_datetime')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_sendcloud');
    }
};
