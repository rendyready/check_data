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
        Schema::create('m_jenis_nota', function (Blueprint $table) {
            $table->id('m_jenis_nota_id');
            $table->string('m_jenis_nota_nama');
            $table->string('m_jenis_nota_group');
            $table->bigInteger('m_jenis_nota_created_by');
            $table->timestampTz('m_jenis_nota_created_at')->useCurrent();
            $table->bigInteger('m_jenis_nota_updated_by')->nullable();
            $table->timestampTz('m_jenis_nota_updated_at')->nullable()->useCurrentOnUpdate()->default(NULL);
            $table->timestampTz('m_jenis_nota_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_jenis_nota');
    }
};
