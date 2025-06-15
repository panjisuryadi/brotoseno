<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSomeDefaultValueToPenjualanSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penjualan_sales', function (Blueprint $table) {
            $table->decimal('total_nominal', 12, 2)->default(0)->nullable()->change();
            $table->decimal('total_weight', 12, 3)->default(0)->change();
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
            $table->decimal('total_nominal', 12, 2)->default(0.01)->nullable()->change();
            $table->decimal('total_weight', 12, 3)->default(0.001)->change();
        });
    }
}
