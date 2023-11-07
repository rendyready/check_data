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
        Schema::table('m_stok', function (Blueprint $table) {
            $table->text('m_stok_client_target')->default(DB::raw('list_waroeng()'))->nullable();
        });

        Schema::table('rekap_trans_jualbeli_detail', function (Blueprint $table) {
            $table->string('r_t_jb_detail_cron_jurnal_status')->default('run');
        });

        Schema::table('rekap_so', function (Blueprint $table) {
            $table->string('rekap_so_cron_jurnal_status')->default('run');
            $table->text('rekap_so_client_target')->nullable();
        });

        Schema::table('rekap_so_detail', function (Blueprint $table) {
            $table->decimal('rekap_so_detail_hpp', 14, 2)->default(0);
            $table->string('rekap_so_detail_cron_jurnal_status')->default('run');
            $table->text('rekap_so_detail_client_target')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('m_stok', 'm_stok_client_target')) {
            Schema::table('m_stok', function (Blueprint $table) {
                $table->dropColumn('m_stok_client_target');
            });
        }
        Schema::table('rekap_trans_jualbeli_detail', function (Blueprint $table) {
            $table->dropColumn('r_t_jb_detail_cron_jurnal_status');
            // $table->dropColumn('r_t_jb_detail_client_target');
        });
        Schema::table('rekap_so', function (Blueprint $table) {
            $table->dropColumn('rekap_so_cron_jurnal_status');
            $table->dropColumn('rekap_so_client_target');
        });
        Schema::table('rekap_so_detail', function (Blueprint $table) {
            $table->dropColumn('rekap_so_detail_hpp');
            $table->dropColumn('rekap_so_detail_cron_jurnal_status');
            $table->dropColumn('rekap_so_detail_client_target');
        });
    }
};
