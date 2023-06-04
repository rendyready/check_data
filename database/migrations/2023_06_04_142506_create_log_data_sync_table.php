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
        Schema::create('log_data_sync', function (Blueprint $table) {
            $table->id('log_data_sync_id');
            $table->string('log_data_sync_cron');
            $table->string('log_data_sync_table');
            $table->string('log_data_sync_last');
            $table->string('log_data_sync_note')->nullable();
            $table->timestampTz('log_data_sync_datetime')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_data_sync');
    }
};
