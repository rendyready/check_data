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
        Schema::create('rekap_beli_detail', function (Blueprint $table) {
            $table->id('rekap_beli_detal_id');
            $table->string('rekap_beli_detail_code'); //ambil dari rekap beli
            $table->string('rekap_beli_brg_code');
            $table->string('rekap_beli_nama_brg');
            $table->decimal('rekap_beli_detail_qty',5,2);
            $table->string('rekap_beli_detail_harga');
            $table->string('rekap_beli_detail_disc');
            $table->string('rekap_beli_detail_discrp');
            $table->string('rekap_beli_detail_subtot');
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
        Schema::dropIfExists('rekap_beli_detail');
    }
};
