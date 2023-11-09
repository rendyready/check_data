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
        Schema::create('users_history', function (Blueprint $table) {
            $table->id('users_history_id');
            $table->bigInteger('users_history_users_id');
            $table->string('users_history_status');
            $table->date('users_history_date');
            $table->string('users_history_ket',255);
            $table->integer('users_history_created_by');
            $table->timestamp('users_history_created_at');
        });

        Schema::create('m_users_status', function (Blueprint $table) {
            $table->id('m_users_status_id');
            $table->string('m_users_status_nama');
            $table->string('m_users_status_ket')->nullable();
            $table->integer('m_users_status_created_by');
            $table->timestamp('m_users_status_created_at');
            $table->integer('m_users_status_updated_by');
        });

        if (!Schema::hasColumn('users', 'users_status')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('users_status')->nullable();
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
        Schema::dropIfExists('users_history');
        Schema::dropIfExists('m_users_status');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('users_status');
        });
    }
};
