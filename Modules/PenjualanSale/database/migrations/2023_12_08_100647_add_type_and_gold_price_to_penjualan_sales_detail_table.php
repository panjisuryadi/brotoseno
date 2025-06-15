<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeAndGoldPriceToPenjualanSalesDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penjualan_sales_detail', function (Blueprint $table) {
            $table->tinyInteger('type')->nullable()->comment('1 Setorang Uang 2 Setorang emas'); // 1 Setorang Uang 2 Setorang emas
            $table->integer('gold_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penjualan_sales_detail', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('gold_price');
        });
    }
}
