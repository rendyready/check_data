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
        Schema::create('m_produk_code', function (Blueprint $table) {
            $table->id('m_produk_code_id');
            $table->string('m_produk_code_bb');
            $table->string('m_produk_code_bo');
            $table->string('m_produk_code_tl');
            $table->string('m_produk_code_mn');
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
        Schema::dropIfExists('m_produk_code');
    }
};
