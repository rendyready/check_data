<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('m_area', function (Blueprint $table) {
        //     // $table->text('m_area_client_target')->default(DB::raw('list_waroeng()'));
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('m_area', function (Blueprint $table) {
        //     $table->dropColumn(['m_area_client_target']);
        // });
    }
};
