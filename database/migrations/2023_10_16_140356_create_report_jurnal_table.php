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
        Schema::create('report_jurnal', function (Blueprint $table) {
            // $table->id('id');
            // $table->string('r_j_id')->unique();
            $table->uuid('r_j_id')->default(DB::raw('gen_random_uuid()'))->primary();
            $table->unsignedBigInteger('r_j_m_w_id');
            $table->string('r_j_m_w_code');
            $table->string('r_j_m_w_nama');
            $table->unsignedBigInteger('r_j_m_area_id');
            $table->string('r_j_m_area_nama');
            $table->unsignedBigInteger('r_j_m_rekening_id');
            $table->string('r_j_m_rekening_code');
            $table->string('r_j_m_rekening_nama');
            $table->date('r_j_tanggal');
            $table->string('r_j_particul');
            $table->decimal('r_j_debit',15,2);
            $table->decimal('r_j_kredit',15,2);
            $table->string('r_j_transaction_code');
            $table->string('r_j_type');
            $table->string('r_j_users_name');
            $table->unsignedBigInteger('r_j_m_supplier_id')->nullable();
            $table->string('r_j_m_supplier_code')->nullable();
            $table->string('r_j_m_supplier_nama')->nullable();
            $table->unsignedBigInteger('r_j_m_customer_id')->nullable();
            $table->string('r_j_m_customer_code')->nullable();
            $table->string('r_j_m_customer_nama')->nullable();
            $table->bigInteger('r_j_created_by');
            $table->bigInteger('r_j_updated_by')->nullable();
            $table->bigInteger('r_j_deleted_by')->nullable();
            $table->timestampTz('r_j_created_at')->useCurrent();
            $table->timestampTz('r_j_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_j_deleted_at')->nullable()->default(NULL);
            $table->text('r_j_client_target')->nullable();
        });
        DB::statement("CREATE INDEX IF NOT EXISTS report_jurnal_target_idx_1 ON report_jurnal USING GIN (to_tsvector('english', r_j_client_target));");
        DB::statement("CREATE INDEX IF NOT EXISTS idx_gabungan_report_jurnal
        ON report_jurnal
        USING btree
        (r_j_id, r_j_tanggal, r_j_m_rekening_id);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_jurnal');
    }
};
