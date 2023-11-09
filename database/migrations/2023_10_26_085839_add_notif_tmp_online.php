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
        if (!Schema::hasColumn('tmp_online', 'tmp_online_notif')) {
            Schema::table('tmp_online', function (Blueprint $table) {
                $table->integer('tmp_online_notif')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('tmp_online', 'tmp_online_notif')) {
            Schema::table('tmp_online', function (Blueprint $table) {
                $table->dropColumn('tmp_online_notif');
            });
        }
    }
};
