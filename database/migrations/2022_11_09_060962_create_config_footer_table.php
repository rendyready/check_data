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
        Schema::create('config_footer', function (Blueprint $table) {
            $table->id('config_footer_id');
            $table->bigInteger('config_footer_m_w_id');
            $table->string('config_footer_value');
            $table->integer('config_footer_priority');
            $table->bigInteger('config_footer_created_by');
            $table->bigInteger('config_footer_updated_by')->nullable();
            $table->timestampTz('config_footer_created_at')->useCurrent();
            $table->timestampTz('config_footer_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('config_footer_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_footer');
    }
};
