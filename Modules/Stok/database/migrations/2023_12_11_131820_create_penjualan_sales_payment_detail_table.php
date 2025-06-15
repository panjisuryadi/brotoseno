<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenjualanSalesPaymentDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_sales_payment_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_id');
            $table->foreign('payment_id')->references('id')->on('penjualan_sales_payment');
            $table->unsignedTinyInteger('nomor_cicilan');
            $table->date('tanggal_cicilan');
            $table->decimal('jumlah_cicilan', 12, 3, true)->nullable();
            $table->unsignedBigInteger('nominal')->nullable();

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
        Schema::dropIfExists('penjualan_sales_payment_detail');
    }
}
