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
        Schema::create('cronjob', function (Blueprint $table) {
            $table->id('cronjob_id');
            $table->string('cronjob_name');
            $table->string('cronjob_status')->default('open')->comment('open,close');
            $table->timestampTz('cronjob_created_at')->useCurrent();
            $table->timestampTz('cronjob_updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cronjob');
    }
};
