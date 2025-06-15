<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdatePenjualanSalesIdColumnInPenjualanSalesDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::table('penjualan_sales_detail', function (Blueprint $table) {
            $table->dropForeign(['penjualan_sales_id']);
            $table->foreign('penjualan_sales_id')->references('id')->on('penjualan_sales')->onDelete('cascade');
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::table('penjualan_sales_detail', function (Blueprint $table) {
            $table->dropForeign(['penjualan_sales_id']);
            $table->foreign('penjualan_sales_id')->references('id')->on('penjualan_sales');
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
