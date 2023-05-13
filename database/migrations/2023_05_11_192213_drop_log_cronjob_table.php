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
        Schema::dropIfExists('log_cronjob');

        Schema::create('log_cronjob', function (Blueprint $table) {
            $table->id('log_cronjob_id');
            $table->string('log_cronjob_name');
            $table->string('log_cronjob_from_server_id');
            $table->string('log_cronjob_from_server_name');
            $table->string('log_cronjob_to_server_id');
            $table->string('log_cronjob_to_server_name');
            $table->string('log_cronjob_note')->nullable();
            $table->timestampTz('log_cronjob_datetime')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
