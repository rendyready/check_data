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
        Schema::create('m_akun_bank', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('m_akun_bank_id')->unsigned()->nullable();
            $table->unsignedBigInteger('m_akun_bank_m_w_id')->nullable();
            $table->string('m_akun_bank_type')->comment('cash/bank');
            $table->string('m_akun_bank_code');
            $table->string('m_akun_bank_name');
            $table->unsignedBigInteger('m_akun_bank_m_rekening_id')->nullable();
            $table->bigInteger('m_akun_bank_created_by');
            $table->bigInteger('m_akun_bank_updated_by')->nullable();
            $table->bigInteger('m_akun_bank_deleted_by')->nullable();
            $table->timestampTz('m_akun_bank_created_at')->useCurrent();
            $table->timestampTz('m_akun_bank_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_akun_bank_deleted_at')->nullable()->default(NULL);
            $table->text('m_akun_bank_client_target')->default(DB::raw('list_waroeng()'))->nullable();

        });

        DB::statement("CREATE INDEX IF NOT EXISTS m_akun_bank_target_idx_1 ON m_akun_bank USING GIN (to_tsvector('english', m_akun_bank_client_target));");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_akun_bank');
    }
};
