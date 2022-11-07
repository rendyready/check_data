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
            $table->id();
            $table->string('m_area_nama');
            $table->bigInteger('m_area_created_by');
            $table->timestamp('m_area_created_at')->useCurrent();
            $table->bigInteger('m_area_updated_by')->nullable();
            $table->timestamp('m_area_updated_at')->nullable();
            $table->softDeletes('m_area_deleted_at');
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
