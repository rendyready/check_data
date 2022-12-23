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
        Schema::create('payment_method', function (Blueprint $table) {
            $table->id('payment_method_id');
            $table->string('payment_method_type'); //cash,transfer
            $table->string('payment_method_name');
            $table->string('payment_method_logo')->nullable();
            $table->bigInteger('payment_method_created_by');
            $table->bigInteger('payment_method_updated_by')->nullable();
            $table->timestampTz('payment_method_deleted_by')->nullable();
            $table->timestampTz('payment_method_created_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('payment_method_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('payment_method_deleted_at')->nullable()->default(NUll);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_method');
    }
};
