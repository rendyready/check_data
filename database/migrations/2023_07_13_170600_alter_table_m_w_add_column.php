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

        Schema::dropIfExists('log_data_count');
        Schema::create('log_data_count', function (Blueprint $table) {
            $table->id('id');
            $table->string('log_data_count_m_w_id');
            $table->string('log_data_count_m_w_nama');
            $table->string('log_data_count_tabel_nama');
            $table->string('log_data_count_pusat');
            $table->string('log_data_count_waroeng');
            $table->date('log_data_count_tanggal');
            $table->timestampTz('log_data_count_created_at')->useCurrent();
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

        Schema::dropIfExists('log_data_count');
    }
};
