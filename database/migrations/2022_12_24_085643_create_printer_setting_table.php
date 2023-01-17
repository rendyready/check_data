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
        Schema::create('printer_setting', function (Blueprint $table) {
            $table->id('printer_setting_id');
            $table->bigInteger('printer_setting_m_w_id');
            $table->string('printer_setting_type')->comment('usb,network,sharing');
            $table->string('printer_setting_address')->nullable()->comment('auto,ip address, sharing name');
            $table->string('printer_setting_location')->default('kasir');
            $table->integer('printer_setting_width')->default(33);
            $table->string('printer_setting_status')->default('aktif');
            $table->bigInteger('printer_setting_created_by');
            $table->bigInteger('printer_setting_deleted_by')->nullable();
            $table->bigInteger('printer_setting_updated_by')->nullable();
            $table->timestampTz('printer_setting_created_at')->useCurrent();
            $table->timestampTz('printer_setting_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('printer_setting_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('printer_setting');
    }
};
