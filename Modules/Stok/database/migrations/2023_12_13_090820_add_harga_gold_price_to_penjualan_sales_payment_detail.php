<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHargaGoldPriceToPenjualanSalesPaymentDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penjualan_sales_payment_detail', function (Blueprint $table) {
            $table->string('tipe_emas')->nullable();
            $table->tinyInteger('karat_id')->nullable();
            $table->decimal('berat', 12, 3, true)->nullable();
            $table->tinyInteger('harga')->nullable();
            $table->unsignedBigInteger('gold_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penjualan_sales_payment_detail', function (Blueprint $table) {
            $table->dropColumn('tipe_emas');
            $table->dropColumn('karat_id');
            $table->dropColumn('berat');
            $table->dropColumn('harga');
            $table->dropColumn('gold_price');
        });
    }
}
