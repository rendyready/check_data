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
        Schema::create('tmp_online_detail', function (Blueprint $table) {
            $table->uuid('tmp_online_detail_id')->default(DB::raw('gen_random_uuid()'))->primary();
            $table->uuid('tmp_online_detail_tmp_online_id');
            $table->unsignedBigInteger('tmp_online_detail_m_produk_id');
            $table->string('tmp_online_detail_m_produk_nama');
            $table->decimal('tmp_online_detail_price', 8,2);
            $table->integer('tmp_online_detail_qty');
            $table->string('tmp_online_detail_custom')->nullable();
            $table->string('tmp_online_detail_client_target');
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
        Schema::dropIfExists('tmp_online_detail');
    }
};
