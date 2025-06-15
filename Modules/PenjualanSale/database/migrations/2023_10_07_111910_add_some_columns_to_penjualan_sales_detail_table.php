<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSomeColumnsToPenjualanSalesDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penjualan_sales_detail', function (Blueprint $table) {
            $table->enum('harga_type',['persen','nominal']);
            $table->decimal('jumlah', 12, 3)->default(0);
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
            $table->dropColumn(['harga_type','jumlah']);
        });
    }
}
