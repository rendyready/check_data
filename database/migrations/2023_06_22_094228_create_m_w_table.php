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
        Schema::create('m_w', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('m_w_id');
            $table->string('m_w_nama');
            $table->string('m_w_code');
            $table->unsignedBigInteger('m_w_m_area_id');
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
        Schema::dropIfExists('m_w');
    }
};
