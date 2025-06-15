<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKonsumenSalesIdToPenjualanSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penjualan_sales', function (Blueprint $table) {
            $table->unsignedBigInteger('konsumen_sales_id')->nullable();
            
            $table->foreign('konsumen_sales_id')->references('id')->on('customer_sales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penjualan_sales', function (Blueprint $table) {
            $table->dropConstrainedForeignId('konsumen_sales_id');
        });
    }
}
