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
        Schema::create('list_akt', function (Blueprint $table) {
            $table->id('list_akt_id');
            $table->string('list_akt_nama');
            $table->string('list_akt_m_rekening_id')->nullable();
            $table->bigInteger('list_akt_created_by');
            $table->bigInteger('list_akt_updated_by')->nullable();
            $table->bigInteger('list_akt_deleted_by')->nullable();
            $table->timestampTz('list_akt_created_at')->useCurrent();
            $table->timestampTz('list_akt_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('list_akt_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('list_akt');
    }
};
