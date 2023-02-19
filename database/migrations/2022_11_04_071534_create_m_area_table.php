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
        Schema::create('m_area', function (Blueprint $table) {
            $table->id('id');
            $table->string('m_area_id')->unique();
            $table->string('m_area_nama');
            $table->string('m_area_code');
            $table->bigInteger('m_area_created_by');
            $table->bigInteger('m_area_updated_by')->nullable();
            $table->bigInteger('m_area_deleted_by')->nullable();
            $table->timestampTz('m_area_created_at')->useCurrent();
            $table->timestampTz('m_area_updated_at')->nullable()->useCurrentOnUpdate()->default(NULL);
            $table->timestampTz('m_area_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_area');
    }
};
