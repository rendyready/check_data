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
        Schema::create('link_akt', function (Blueprint $table) {
            $table->id('link_akt_id');
            $table->bigInteger('link_akt_m_rekening_id');
            $table->bigInteger('link_akt_list_akt_id');
            $table->bigInteger('link_akt_created_by');
            $table->bigInteger('link_akt_updated_by')->nullable();
            $table->bigInteger('link_akt_deleted_by')->nullable();
            $table->timestampTz('link_akt_created_at')->useCurrent();
            $table->timestampTz('link_akt_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('link_akt_deleted_at')->nullable()->default(NULL);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('link_akt');
    }
};
