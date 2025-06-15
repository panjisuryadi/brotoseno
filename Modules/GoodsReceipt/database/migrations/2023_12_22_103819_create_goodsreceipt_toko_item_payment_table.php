<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsreceiptTokoItemPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goodsreceipt_toko_item_payment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('goodsreceipt_toko_item_id')->constrained('goodsreceipt_toko_items');
            $table->string('payment_method');
            $table->unsignedBigInteger('paid_amount');
            $table->unsignedInteger('return_amount')->nullable();
            $table->foreignId('bank_id')->nullable()->constrained('databanks');
            $table->foreignId('edc_id')->nullable()->constrained('datarekenings');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goodsreceipt_toko_item_payment');
    }
}
