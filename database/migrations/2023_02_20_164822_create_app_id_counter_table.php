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
        Schema::create('app_id_counter', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('app_id_counter_m_w_id');
            $table->string('app_id_counter_table');
            $table->unsignedBigInteger('app_id_counter_value');
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
        Schema::dropIfExists('app_idtable_counter');
    }
};
