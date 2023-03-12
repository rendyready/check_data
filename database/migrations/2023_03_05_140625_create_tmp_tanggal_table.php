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
        Schema::create('tmp_tanggal', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('tmp_tanggal_r_t_id');
            $table->date('tmp_tanggal_date');
            $table->bigInteger('tmp_tanggal_created_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('tmp_tanggal');
    }
};
