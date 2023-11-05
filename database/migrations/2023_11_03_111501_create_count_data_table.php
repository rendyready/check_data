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
        Schema::create('log_data_check', function (Blueprint $table) {
            $table->id('id');
            $table->string('log_data_check_m_w_id');
            $table->string('log_data_check_m_w_nama');
            $table->string('log_data_check_table_nama');
            $table->string('log_data_check_pusat');
            $table->string('log_data_check_waroeng');
            $table->date('log_data_check_tanggal');
            $table->string('log_data_check_status');
            $table->timestampTz('log_data_check_created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_data_check');
    }
};
