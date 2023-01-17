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
        Schema::create('m_gudang_nama', function (Blueprint $table) {
            $table->id('m_gudang_nama_id');
            $table->string('m_gudang_nama');
            $table->bigInteger('m_gudang_nama_created_by');
            $table->bigInteger('m_gudang_nama_updated_by')->nullable();
            $table->bigInteger('m_gudang_nama_deleted_by')->nullable();
            $table->timestampTz('m_gudang_nama_created_at')->useCurrent();
            $table->timestampTz('m_gudang_nama_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_gudang_nama_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_gudang_nama');
    }
};
