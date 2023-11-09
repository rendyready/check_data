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
        Schema::create('rekap_member', function (Blueprint $table) {
            $table->id('id');
            $table->string('rekap_member_id')->unique();
            $table->string('rekap_member_phone');
            $table->string('rekap_member_name');
            $table->string('rekap_member_status_sync', 20)->default('send');
            $table->bigInteger('rekap_member_created_by');
            $table->bigInteger('rekap_member_updated_by')->nullable();
            $table->bigInteger('rekap_member_deleted_by')->nullable();
            $table->timestampTz('rekap_member_created_at')->useCurrent();
            $table->timestampTz('rekap_member_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('rekap_member_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_member');
    }
};
