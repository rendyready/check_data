<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('m_tipe_nota');
        Schema::create('m_tipe_nota', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('m_tipe_nota_id')->unsigned();
            $table->string('m_tipe_nota_nama');
            $table->string('m_tipe_nota_status_sync')->default('send');
            $table->text('m_tipe_nota_client_target')->default(DB::raw('list_waroeng()'))->nullable();
            $table->bigInteger('m_tipe_nota_created_by');
            $table->bigInteger('m_tipe_nota_updated_by')->nullable();
            $table->bigInteger('m_tipe_nota_deleted_by')->nullable();
            $table->timestampTz('m_tipe_nota_created_at')->useCurrent();
            $table->timestampTz('m_tipe_nota_updated_at')->nullable()->useCurrentOnUpdate()->default(NULL);
            $table->timestampTz('m_tipe_nota_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_tipe_nota');
    }
};
