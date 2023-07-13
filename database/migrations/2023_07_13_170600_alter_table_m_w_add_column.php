<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::table('m_w', function (Blueprint $table) {
            $table->timestampTz('m_w_server_status')->nullable();
            $table->timestampTz('m_w_mikrotik_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_w', function (Blueprint $table) {
            $table->dropColumn('m_w_server_status');
            $table->dropColumn('m_w_mikrotik_status');
        });
    }
};
