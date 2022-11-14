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
        Schema::create('m_pajak', function (Blueprint $table) {
            $table->id('m_pajak_id');
            $table->decimal('m_pajak_value',3,2);
            $table->bigInteger('m_pajak_created_by');
            $table->timestampTz('m_pajak_created_at')->useCurrent();
            $table->bigInteger('m_pajak_updated_by')->nullable();
            $table->timestampTz('m_pajak_updated_at')->nullable()->useCurrentOnUpdate()->default(NULL);
            $table->timestampTz('m_pajak_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_pajak');
    }
};
