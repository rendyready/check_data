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
        Schema::create('tmp_user_cr', function (Blueprint $table) {
            $table->uuid('tmp_user_cr_id')->default(DB::raw('gen_random_uuid()'))->primary();
            $table->bigInteger('tmp_user_cr_users_id');
            $table->unsignedBigInteger('tmp_user_cr_m_w_id');
            $table->date('tmp_user_cr_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tmp_user_cr');
    }
};
