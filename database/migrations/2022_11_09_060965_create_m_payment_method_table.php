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
        Schema::create('m_payment_method', function (Blueprint $table) {
            $table->id('m_payment_method_id');
            $table->string('m_payment_method_type'); //cash,transfer
            $table->string('m_payment_method_name');
            $table->string('m_payment_method_color')->nullable()->default('#B7C4CF');
            $table->bigInteger('m_payment_method_created_by');
            $table->bigInteger('m_payment_method_updated_by')->nullable();
            $table->timestampTz('m_payment_method_deleted_by')->nullable();
            $table->timestampTz('m_payment_method_created_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_payment_method_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_payment_method_deleted_at')->nullable()->default(NUll);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_payment_method');
    }
};
