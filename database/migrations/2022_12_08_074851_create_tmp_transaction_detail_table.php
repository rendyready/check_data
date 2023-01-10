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
        Schema::create('tmp_transaction_detail', function (Blueprint $table) {
            $table->uuid('tmp_transaction_detail_id')->default(DB::raw('gen_random_uuid()'))->primary();
            $table->uuid('tmp_transaction_detail_tmp_transaction_id');
            $table->bigInteger('tmp_transaction_detail_m_produk_id')->nullable();
            $table->integer('tmp_transaction_detail_qty')->default(1)->comment('qty menu');
            $table->bigInteger('tmp_transaction_detail_created_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->integer('tmp_transaction_detail_status')->default(0)->comment('0 new transaction, 1 paid, 2 garansi, 3 ganti baru, 4 gratis');
            $table->integer('tmp_transaction_detail_qty_approve')->nullable()->comment('qty menu approve');
            $table->text('tmp_transaction_detail_reasone_approve')->nullable();
            $table->decimal('tmp_transaction_detail_tax',8,2)->default(0)->comment('percentage tax');
            $table->decimal('tmp_transaction_detail_service_charge',8,2)->nullable()->comment('percentage percentage charge');
            $table->decimal('tmp_transaction_detail_discount',8,2)->default(0)->comment('percentage discount');
            $table->decimal('tmp_transaction_detail_price',15,2)->default(0);
            $table->decimal('tmp_transaction_detail_nominal',15,2)->default(0);
            $table->text('tmp_transaction_detail_custom_menu')->nullable();
            $table->boolean('tmp_transaction_detail_tax_status')->default(true);
            $table->boolean('tmp_transaction_detail_service_charge_status')->default(true);
            $table->integer('tmp_transaction_detail_production_status')->default(0)->comment('0 not on production, 1 on production, 2 production cancelled');
            $table->enum('tmp_transaction_detail_discount_type', ['Persen', 'Nominal', 'Qty', 'CustomPrice'])->default('CustomPrice');
        });

        // Schema::table('tmp_transaction_detail', function (Blueprint $table) {
        //     $table->foreign(['tmp_transaction_detail_tmp_transaction_id'], 'tmp_transaction_detail_tmp_transaction_id_fkey')->references(['tmp_transaction_id'])->on('tmp_transaction')->onUpdate('CASCADE')->onDelete('CASCADE');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tmp_transaction_detail');
    }
};
