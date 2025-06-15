<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSomeDefaultValueToPenjualanSalesDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penjualan_sales_detail', function (Blueprint $table) {
            $table->decimal('nominal', 12, 2)->default(0)->nullable()->change();
            $table->decimal('weight', 12, 3)->default(0)->change();
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
            $table->decimal('nominal', 12, 2)->default(0.01)->nullable()->change();
            $table->decimal('weight', 12, 3)->default(0.001)->change();
        });
    }
}
