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
        Schema::create('rph', function (Blueprint $table) {
            $table->id('id');
            $table->string('rph_code');
            $table->date('rph_tgl');
            $table->BigInteger('rph_m_w_id');
            $table->string('rph_m_w_nama');
            $table->bigInteger('rph_created_by');
            $table->bigInteger('rph_updated_by')->nullable();
            $table->bigInteger('rph_deleted_by')->nullable();
            $table->timestampTz('rph_created_at')->useCurrent();
            $table->timestampTz('rph_updated_at')->nullable()->useCurrentOnUpdate()->default(NULL);
            $table->timestampTz('rph_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rph');
    }
};
