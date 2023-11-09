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
        Schema::table('rph_detail_bb', function (Blueprint $table) {
            $table->string('rph_detail_bb_rph_detail_menu_id')->after('rph_detail_bb_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rph_detail_bb', function (Blueprint $table) {
            $table->dropColumn('rph_detail_bb_rph_detail_menu_id');
        });
    }
};
