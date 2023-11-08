<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMFaqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_faq', function (Blueprint $table) {
            $table->id('m_faq_id');
            $table->text('m_faq_judul');
            $table->text('m_faq_deskripsi');
            $table->string('m_faq_tag')->nullable();
            $table->bigInteger('m_faq_created_by');
            $table->bigInteger('m_faq_updated_by')->nullable();
            $table->bigInteger('m_faq_deleted_by')->nullable();
            $table->timestampTz('m_faq_created_at')->useCurrent();
            $table->timestampTz('m_faq_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_faq_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_faq');
    }
}
