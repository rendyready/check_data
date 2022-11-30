<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMFaqKelompokTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_faq_kelompok', function (Blueprint $table) {
            $table->id('m_faq_kelompok_id');
            $table->bigInteger('m_faq_kelompok_m_faq_id');
            $table->bigInteger('m_faq_kelompok_m_kelompok_id');
            $table->bigInteger('m_faq_kelompok_created_by');
            $table->bigInteger('m_faq_kelompok_updated_by')->nullable();
            $table->bigInteger('m_faq_kelompok_deleted_by')->nullable();
            $table->timestampTz('m_faq_kelompok_created_at')->useCurrent();
            $table->timestampTz('m_faq_kelompok_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_faq_kelompok_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_faq_kelompok');
    }
}
