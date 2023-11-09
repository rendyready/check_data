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
        Schema::dropIfExists('m_link_akuntansi');

        Schema::create('m_link_akuntansi', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('m_link_akuntansi_id')->unsigned()->nullable();
            $table->string('m_link_akuntansi_nama');
            $table->unsignedBigInteger('m_link_akuntansi_m_rekening_id');
            $table->bigInteger('m_link_akuntansi_created_by');
            $table->bigInteger('m_link_akuntansi_updated_by')->nullable();
            $table->bigInteger('m_link_akuntansi_deleted_by')->nullable();
            $table->timestampTz('m_link_akuntansi_created_at')->useCurrent();
            $table->timestampTz('m_link_akuntansi_updated_at')->useCurrentOnUpdate()->nullable()->default(null);
            $table->timestampTz('m_link_akuntansi_deleted_at')->nullable()->default(null);
            $table->text('m_link_akuntansi_client_target')->default(DB::raw('list_waroeng()'))->nullable();
        });

        DB::statement("CREATE INDEX IF NOT EXISTS m_link_akuntansi_target_idx_1 ON m_link_akuntansi USING GIN (to_tsvector('english', m_link_akuntansi_client_target));");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_link_akuntansi');
    }
};
