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
        Schema::create('m_pin', function (Blueprint $table) {
            $table->id('m_pin_id');
            $table->string('m_pin_value');
            $table->string('m_pin_type');
            $table->string('m_pin_access'); //allow, deny
            $table->char('m_pin_status', 1)->default('1');
            $table->bigInteger('m_pin_created_by');
            $table->bigInteger('m_pin_updated_by')->nullable()->default(NULL);
            $table->bigInteger('m_pin_deleted_by')->nullable()->default(NULL);
            $table->timestampTz('m_pin_created_at')->useCurrent();
            $table->timestampTz('m_pin_updated_at')->useCurrentOnUpdate()->nullable()->useCurrent()->default(NULL);
            $table->timestampTz('m_pin_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_pin');
    }
};
