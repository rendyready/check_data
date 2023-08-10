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
        Schema::create('tmp_online', function (Blueprint $table) {
            $table->uuid('tmp_online_id')->default(DB::raw('gen_random_uuid()'))->primary();
            $table->unsignedBigInteger('tmp_online_m_w_id');
            $table->string('tmp_online_m_w_nama');
            $table->string('tmp_online_code')->comment('generate code and queue');
            $table->string('tmp_online_trans_type')->comment('dine in,take away');
            $table->string('tmp_online_table')->nullable();
            $table->string('tmp_online_bigboss_name');
            $table->string('tmp_online_bigboss_phone')->nullable();
            $table->date('tmp_online_date');
            $table->time('tmp_online_time');
            $table->string('tmp_online_client_target');
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
        Schema::dropIfExists('tmp_online');
    }
};
