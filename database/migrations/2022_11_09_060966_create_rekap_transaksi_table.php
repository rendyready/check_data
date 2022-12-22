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
        Schema::create('rekap_transaksi', function (Blueprint $table) {
            $table->id('r_t_id');
            $table->bigInteger('r_t_sync_id')->nullable();
            $table->bigInteger('r_t_rekap_modal_id');
            $table->bigInteger('r_t_m_jenis_nota_id');
            $table->string('r_t_m_jenis_nota_nama');
            $table->string('r_t_tmp_transaction_id')->comment('Untuk cek duplikasi input');
            $table->string('r_t_nota_code');
            $table->string('r_t_bigboss');
            // $table->smallInteger('r_t_shift');
            $table->date('r_t_tanggal');
            $table->time('r_t_jam');
            $table->bigInteger('r_t_m_area_id');
            $table->string('r_t_m_area_nama');
            $table->bigInteger('r_t_m_w_id');
            $table->string('r_t_m_w_nama');
            $table->decimal('r_t_nominal', 15,2)->default(0);
            $table->decimal('r_t_nominal_pajak', 15,2)->default(0);
            $table->decimal('r_t_nominal_sc', 15,2)->default(0);
            $table->decimal('r_t_nominal_sharing_profit', 15,2)->default(0);
            $table->decimal('r_t_nominal_diskon', 15,2)->default(0);
            $table->decimal('r_t_nominal_voucher', 15,2)->default(0);
            $table->decimal('r_t_nominal_pembulatan', 8,2)->default(0);
            $table->decimal('r_t_nominal_tarik_tunai', 15,2)->default(0);
            $table->decimal('r_t_nominal_total_bayar', 15,2)->default(0);
            $table->decimal('r_t_nominal_total_uang', 15,2)->default(0);
            
            $table->decimal('r_t_nominal_kembalian', 15,2)->default(0);
            $table->decimal('r_t_nominal_free_kembalian', 15,2)->default(0);
            $table->decimal('r_t_nominal_total_kembalian', 15,2)->default(0);
            

            $table->decimal('r_t_nominal_void', 15,2)->default(0);
            $table->decimal('r_t_nominal_void_pajak', 15,2)->default(0);
            $table->decimal('r_t_nominal_void_sc', 15,2)->default(0);
            $table->decimal('r_t_nominal_pembulatan_void', 15,2)->default(0);
            $table->decimal('r_t_nominal_free_kembalian_void', 15,2)->default(0);

            $table->bigInteger('r_t_m_t_t_id');
            $table->string('r_t_m_t_t_name');
            $table->string('r_t_status');
            $table->string('r_t_catatan')->nullable();
            $table->char('r_t_status_sync', 1)->default('0');
            $table->bigInteger('r_t_created_by');
            $table->bigInteger('r_t_updated_by')->nullable();
            $table->bigInteger('r_t_deleted_by')->nullable();
            $table->timestampTz('r_t_created_at')->useCurrent();
            $table->timestampTz('r_t_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_t_deleted_at')->nullable()->default(NULL);

            // $table->index(['r_t_nota_code', 'r_t_tanggal', 'r_t_jam', 'r_t_m_w_id'], 'mrt_counter_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_transaksi');
    }
};
