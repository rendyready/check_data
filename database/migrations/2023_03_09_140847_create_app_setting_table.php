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
        Schema::create('app_setting', function (Blueprint $table) {
            $table->id('app_setting_id');
            $table->unsignedBigInteger('app_setting_m_w_id');
            $table->string('app_setting_key_wa')->nullable();
            $table->string('app_setting_device_wa')->nullable();
            $table->string('app_setting_url_server_struk')->nullable();
            $table->string('app_setting_key_server_struk')->nullable();
            $table->bigInteger('app_setting_created_by');
            $table->bigInteger('app_setting_updated_by')->nullable();
            $table->bigInteger('app_setting_deleted_by')->nullable();
            $table->timestampTz('app_setting_created_at')->useCurrent();
            $table->timestampTz('app_setting_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('app_setting_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_setting');
    }
};
