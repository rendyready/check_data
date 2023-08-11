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
        Schema::create('config_parent', function (Blueprint $table) {
            $table->id('config_parent_id');
            $table->string('config_parent_name');
            $table->string('config_parent_status')->default('on')->comment('on/off');
            $table->string('config_parent_pkey');
            $table->string('config_parent_child_name');
            $table->string('config_parent_child_pkey');
            $table->string('config_parent_child_fkey');
            $table->timestampTz('config_parent_created_at')->useCurrent();
            $table->timestampTz('config_parent_updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_parent');
    }
};
