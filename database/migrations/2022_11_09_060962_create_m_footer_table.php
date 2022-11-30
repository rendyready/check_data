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
        Schema::create('m_footer', function (Blueprint $table) {
            $table->id('m_footer_id');
            $table->bigInteger('m_footer_m_w_id');
            $table->string('m_footer_value');
            $table->integer('m_footer_priority');
            $table->bigInteger('m_footer_created_by');
            $table->bigInteger('m_footer_updated_by')->nullable();
            $table->bigInteger('m_footer_deleted_by')->nullable();
            $table->timestampTz('m_footer_created_at')->useCurrent();
            $table->timestampTz('m_footer_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_footer_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_footer');
    }
};
