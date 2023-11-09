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
        Schema::dropIfExists('rekap_jurnal_bank');

        Schema::create('rekap_jurnal_bank', function (Blueprint $table) {
            $table->id('id');
            $table->string('r_j_b_id')->unique();
            $table->unsignedBigInteger('r_j_b_m_w_id');
            $table->string('r_j_b_m_w_code');
            $table->string('r_j_b_m_w_nama');
            $table->unsignedBigInteger('r_j_b_m_area_id');
            $table->string('r_j_b_m_area_nama');
            $table->unsignedBigInteger('r_j_b_m_akun_bank_id');
            $table->unsignedBigInteger('r_j_b_m_rekening_id');
            $table->string('r_j_b_m_rekening_code');
            $table->string('r_j_b_m_rekening_nama');
            $table->date('r_j_b_tanggal');
            $table->string('r_j_b_particul');
            $table->decimal('r_j_b_debit', 15,2)->default(0);
            $table->decimal('r_j_b_kredit', 15,2)->default(0);
            $table->string('r_j_b_transaction_code');
            $table->string('r_j_b_status')->nullable()->comment('in/out');
            $table->string('r_j_b_users_name');
            $table->string('r_j_b_cron_jurnal_status')->default('run');
            $table->bigInteger('r_j_b_created_by');
            $table->bigInteger('r_j_b_updated_by')->nullable();
            $table->bigInteger('r_j_b_deleted_by')->nullable();
            $table->timestampTz('r_j_b_created_at')->useCurrent();
            $table->timestampTz('r_j_b_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_j_b_deleted_at')->nullable()->default(NULL);
            $table->text('r_j_b_client_target')->nullable();
        });

        DB::statement("CREATE INDEX IF NOT EXISTS rekap_jurnal_bank_target_idx_1 ON rekap_jurnal_bank USING GIN (to_tsvector('english', r_j_b_client_target));");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_jurnal_bank');
    }
};
