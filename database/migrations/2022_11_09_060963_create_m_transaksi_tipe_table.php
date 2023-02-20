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
        Schema::create('m_transaksi_tipe', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('m_t_t_id');
            $table->string('m_t_t_name');
            $table->decimal('m_t_t_profit_price', 8, 2);
            $table->decimal('m_t_t_profit_in', 8, 2);
            $table->decimal('m_t_t_profit_out', 8, 2);
            $table->string('m_t_t_group');
            $table->bigInteger('m_t_t_created_by');
            $table->bigInteger('m_t_t_updated_by')->nullable();
            $table->bigInteger('m_t_t_deleted_by')->nullable();
            $table->timestampTz('m_t_t_created_at')->useCurrent();
            $table->timestampTz('m_t_t_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_t_t_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_transaksi_tipe');
    }
};
