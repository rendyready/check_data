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
        Schema::create('tmp_transaction', function (Blueprint $table) {
            // $table->uuid('tmp_transaction_id')->default(DB::raw('gen_random_uuid()'))->primary();
            $table->uuid('tmp_transaction_id_parent')->nullable();
            $table->bigInteger('tmp_transaction_m_t_t_id')->nullable();
            $table->bigInteger('tmp_transaction_m_w_id')->nullable();
            $table->string('tmp_transaction_note_number', 18)->nullable()->comment('Note Number');
            $table->string('tmp_transaction_customer_name', 32)->nullable()->comment('Name Customer or bigboss');
            $table->time('tmp_transaction_order_time')->nullable()->comment('Order Time');
            $table->jsonb('tmp_transaction_table_list')->nullable()->comment('List Table in Here');
            $table->integer('tmp_transaction_status')->default(0)->comment('0 new transaction, 1 not yet paid, 2 get paid, 3 cancel transaction');
            $table->string('tmp_transaction_reason_status', 128)->nullable()->comment('Reason if cancel transaction');
            $table->bigInteger('tmp_transaction_created_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
            // $table->decimal('tmp_transaction_menu_service_charge', 15)->nullable()->default(0);
            // $table->decimal('tmp_transaction_tarik_tunai', 15)->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tmp_transaction');
    }
};
