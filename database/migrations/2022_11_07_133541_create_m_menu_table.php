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
        Schema::create('m_menu', function (Blueprint $table) {
            $table->id();
            $table->string('m_menu_code')->nullable();
            $table->string('m_menu_nama');
            $table->string('m_menu_urut');
            $table->string('m_menu_cr')->nullable();
            $table->char('m_menu_status')->default(1);
            $table->char('m_menu_tax')->default(1);
            $table->char('m_menu_sc')->default(1);
            $table->bigInteger('m_menu_m_menu_jenis_id');
            $table->bigInteger('m_menu_m_plot_produksi_id')->nullable();
            $table->bigInteger('m_menu_created_by');
            $table->timestampTz('m_menu_created_at')->useCurrent();
            $table->bigInteger('m_menu_updated_by')->nullable();
            $table->timestampTz('m_menu_updated_at')->nullable()->useCurrentOnUpdate()->default(NULL);
            $table->timestampTz('m_menu_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_menu');
    }
};
