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
        Schema::table('db_con', function (Blueprint $table) {
            $table->string('db_con_sync_status')->default('on')->comment('on/off')->change();
            $table->string('db_con_getdata_status')->nullable()->comment('source/target');
            $table->string('db_con_senddata_status')->nullable()->comment('source/target');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('db_con', function (Blueprint $table) {
            $table->string('db_con_sync_status')->default('aktif')->comment('aktif/tidak')->change();
            $table->dropColumn(['db_con_getdata_status','db_con_senddata_status']);
        });
    }
};
