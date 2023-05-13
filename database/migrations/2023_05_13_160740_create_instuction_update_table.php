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
        Schema::create('instuction_update', function (Blueprint $table) {
            $table->id('instuction_update_id');
            $table->string('instuction_update_app_name');
            $table->string('instuction_update_base_path');
            $table->string('instuction_update_syntax');
            $table->integer('instuction_update_order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instuction_update');
    }
};
