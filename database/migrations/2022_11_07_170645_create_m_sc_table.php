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
        Schema::create('m_sc', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('m_sc_id');
            $table->decimal('m_sc_value',5,2);
            $table->bigInteger('m_sc_created_by');
            $table->bigInteger('m_sc_updated_by')->nullable();
            $table->bigInteger('m_sc_deleted_by')->nullable();
            $table->timestampTz('m_sc_created_at')->useCurrent();
            $table->timestampTz('m_sc_updated_at')->nullable()->useCurrentOnUpdate()->default(NULL);
            $table->timestampTz('m_sc_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_sc');
    }
};
