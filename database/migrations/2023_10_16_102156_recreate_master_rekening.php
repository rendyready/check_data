<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::dropIfExists('m_rekening');

        Schema::create('m_rekening', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('m_rekening_id')->unsigned()->nullable();
            $table->unsignedBigInteger('m_rekening_parent_id')->nullable();
            $table->unsignedBigInteger('m_rekening_m_w_id')->nullable();
            $table->string('m_rekening_m_w_code')->nullable();
            $table->string('m_rekening_kategori');
            $table->string('m_rekening_code');
            $table->string('m_rekening_nama');
            $table->decimal('m_rekening_saldo', 15, 2)->default(0);
            $table->text('m_rekening_item')->nullable();
            $table->bigInteger('m_rekening_created_by');
            $table->bigInteger('m_rekening_updated_by')->nullable();
            $table->bigInteger('m_rekening_deleted_by')->nullable();
            $table->timestampTz('m_rekening_created_at')->useCurrent();
            $table->timestampTz('m_rekening_updated_at')->useCurrentOnUpdate()->nullable()->default(null);
            $table->timestampTz('m_rekening_deleted_at')->nullable()->default(null);
            $table->text('m_rekening_client_target')->default(DB::raw('list_waroeng()'))->nullable();

        });

        DB::statement("CREATE INDEX IF NOT EXISTS m_rekening_target_idx_1 ON m_rekening USING GIN (to_tsvector('english', m_rekening_client_target));");
        DB::statement("CREATE INDEX IF NOT EXISTS m_rekening_item_idx_1 ON m_rekening USING GIN (to_tsvector('english', m_rekening_item));");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_rekening');
    }
};
