<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenjualanSalesPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_sales_payment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penjualan_sales_id');
             $table->string('tipe_pembayaran')->nullable();
             $table->string('lunas')->nullable();
             $table->tinyInteger('cicil')->default(0);
             $table->date('jatuh_tempo')->nullable();
             $table->foreign('penjualan_sales_id')->references('id')->on('penjualan_sales')->onDelete('cascade');
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
        Schema::dropIfExists('penjualan_sales_payment');
    }
}
