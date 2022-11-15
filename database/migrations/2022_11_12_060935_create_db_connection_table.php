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
        Schema::create('db_connection', function (Blueprint $table) {
            $table->id('db_connection_id');
            $table->bigInteger('db_connection_client_code');
            $table->string('db_connection_host');
            $table->string('db_connection_port');
            $table->string('db_connection_dbname');
            $table->string('db_connection_username');
            $table->string('db_connection_password');
            $table->char('db_connection_status')->nullable()->default('gagal'); //terhubung,gagal
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
        Schema::dropIfExists('db_connection');
    }
};
