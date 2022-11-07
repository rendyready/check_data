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
            $table->id();
            $table->decimal('m_sc_value',3,2);
            $table->bigInteger('m_sc_created_by');
            $table->timestamp('m_sc_created_at')->useCurrent();
            $table->bigInteger('m_sc_updated_by')->nullable();
            $table->timestamp('m_sc_updated_at')->useCurrentOnUpdate();
            $table->softDeletes('m_sc_deleted_at');
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
