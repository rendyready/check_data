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
        Schema::create('m_plot_produksi', function (Blueprint $table) {
            $table->id('m_plot_produksi_id');
            $table->string('m_plot_produksi_nama');
            $table->bigInteger('m_plot_produksi_created_by');
            $table->bigInteger('m_plot_produksi_updated_by')->nullable();
            $table->bigInteger('m_plot_produksi_deleted_by')->nullable();
            $table->timestampTz('m_plot_produksi_created_at')->useCurrent();
            $table->timestampTz('m_plot_produksi_updated_at')->nullable()->useCurrentOnUpdate()->default(NULL);
            $table->timestampTz('m_plot_produksi_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_plot_produksi');
    }
};
