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
        Schema::create('m_bb_relasi', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('m_bb_relasi_id');
            $table->string('m_bb_relasi_m_produk_code_asal');
            $table->string('m_bb_relasi_qty_konversi');
            $table->string('m_bb_relasi_m_produk_code_master');
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
        Schema::dropIfExists('m_bb_relasi');
    }
};
