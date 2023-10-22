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
        Schema::create('rekap_trans_jualbeli', function (Blueprint $table) {
            $table->id('id');
            $table->string('r_t_jb_id')->unique();
            $table->string('r_t_jb_code_nota')->nullable(); //code nota dari supplier jika ada
            $table->date('r_t_jb_tgl');
            $table->date('r_t_jb_jth_tmp')->nullable();
            $table->string('r_t_jb_type');
            $table->string('r_t_jb_m_gudang_code');
            $table->string('r_t_jb_m_supplier_code')->nullable();
            $table->string('r_t_jb_m_supplier_nama')->nullable();
            $table->string('r_t_jb_m_supplier_telp')->nullable();
            $table->string('r_t_jb_m_supplier_alamat')->nullable();
            $table->string('r_t_jb_m_customer_code')->nullable();
            $table->string('r_t_jb_m_customer_nama')->nullable();
            $table->bigInteger('r_t_jb_m_w_id_asal');
            $table->string('r_t_jb_m_w_nama_asal');
            $table->bigInteger('r_t_jb_m_w_id_tujuan');
            $table->string('r_t_jb_m_w_nama_tujuan');
            $table->decimal('r_t_jb_sub_total_beli',16,2);
            $table->string('r_t_jb_m_area_code_asal');
            $table->string('r_t_jb_m_area_nama_asal');
            $table->string('r_t_jb_m_area_code_tujuan');
            $table->string('r_t_jb_m_area_nama_tujuan');
            $table->decimal('r_t_jb_disc',15,2)->default(0)->comment('percent');
            $table->decimal('r_t_jb_nominal_disc',15,2)->default(0);
            $table->decimal('r_t_jb_ppn',15,2)->default(0)->comment('percent');
            $table->decimal('r_t_jb_nominal_ppn',15,2)->default(0);
            $table->decimal('r_t_jb_nominal_ongkir',15,2)->default(0);
            $table->decimal('r_t_jb_nominal_total_beli',16,2);
            $table->decimal('r_t_jb_nominal_bayar',16,2)->default(0);
            $table->string('r_t_jb_ket')->nullable();
            $table->string('r_t_jb_transaction_code')->nullable();
            $table->unsignedBigInteger('r_t_jb_m_akun_bank_id')->nullable();
            $table->unsignedBigInteger('r_t_jb_m_akun_hutang_id')->nullable();
            $table->unsignedBigInteger('r_t_jb_m_akun_piutang_id')->nullable();
            $table->unsignedBigInteger('r_t_jb_m_rekening_id')->nullable();
            $table->string('r_t_jb_m_rekening_code')->nullable();
            $table->string('r_t_jb_m_rekening_nama')->nullable();
            $table->string('r_t_jb_cron_jurnal_status')->default('run');
            $table->bigInteger('r_t_jb_created_by');
            $table->bigInteger('r_t_jb_updated_by')->nullable();
            $table->bigInteger('r_t_jb_deleted_by')->nullable();
            $table->timestampTz('r_t_jb_created_at')->useCurrent();
            $table->timestampTz('r_t_jb_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_t_jb_deleted_at')->nullable()->default(NULL);
            $table->text('r_t_jb_client_target')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_trans_jualbeli');
    }
};
