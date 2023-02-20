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
        Schema::create('m_satuan', function (Blueprint $table) {
            $table->id('id');
            $table->string('m_satuan_id')->unique();
            $table->string('m_satuan_kode');
            $table->string('m_satuan_keterangan')->nullable()->default(NULL);
            $table->bigInteger('m_satuan_created_by');
            $table->bigInteger('m_satuan_updated_by')->nullable();
            $table->bigInteger('m_satuan_deleted_by')->nullable();
            $table->timestampTz('m_satuan_created_at')->useCurrent();
            $table->timestampTz('m_satuan_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_satuan_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_satuan');
    }
};
