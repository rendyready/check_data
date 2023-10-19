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
        Schema::dropIfExists('rekap_jurnal_kas');

        Schema::create('rekap_jurnal_kas', function (Blueprint $table) {
            $table->id('id');
            $table->string('r_j_k_id')->unique();
            $table->unsignedBigInteger('r_j_k_m_w_id');
            $table->string('r_j_k_m_w_code');
            $table->string('r_j_k_m_w_nama');
            $table->unsignedBigInteger('r_j_k_m_area_id');
            $table->string('r_j_k_m_area_nama');
            $table->unsignedBigInteger('r_j_k_m_akun_bank_id');
            $table->unsignedBigInteger('r_j_k_m_rekening_id');
            $table->string('r_j_k_m_rekening_code');
            $table->string('r_j_k_m_rekening_nama');
            $table->date('r_j_k_tanggal');
            $table->string('r_j_k_particul');
            $table->decimal('r_j_k_debit',15,2)->default(0);
            $table->decimal('r_j_k_kredit',15,2)->default(0);
            $table->string('r_j_k_transaction_code');
            $table->string('r_j_k_status')->nullable()->comment('in/out');
            $table->string('r_j_k_users_name');
            $table->string('r_j_k_cron_jurnal_status')->default('run');
            $table->bigInteger('r_j_k_created_by');
            $table->bigInteger('r_j_k_updated_by')->nullable();
            $table->bigInteger('r_j_k_deleted_by')->nullable();
            $table->timestampTz('r_j_k_created_at')->useCurrent();
            $table->timestampTz('r_j_k_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_j_k_deleted_at')->nullable()->default(NULL);
            $table->text('r_j_k_client_target')->nullable();

        });

        DB::statement("CREATE INDEX IF NOT EXISTS rekap_jurnal_kas_target_idx_1 ON rekap_jurnal_kas USING GIN (to_tsvector('english', r_j_k_client_target));");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_jurnal_kas');
    }
};
