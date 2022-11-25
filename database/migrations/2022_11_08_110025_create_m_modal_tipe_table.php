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
        Schema::create('m_modal_tipe', function (Blueprint $table) {
            $table->id('m_modal_tipe_id');
            $table->string('m_modal_tipe_nama');
            $table->bigInteger('m_modal_tipe_parent_id')->nullable();
            $table->decimal('m_modal_tipe_nominal',15,2)->nullable();
            $table->decimal('m_modal_tipe_urut',15,2)->nullable();
            $table->bigInteger('m_modal_tipe_created_by');
            $table->timestampTz('m_modal_tipe_created_at')->useCurrent();
            $table->bigInteger('m_modal_tipe_updated_by')->nullable();
            $table->timestampTz('m_modal_tipe_updated_at')->nullable()->useCurrentOnUpdate()->default(NULL);
            $table->timestampTz('m_modal_tipe_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_modal_tipe');
    }
};
