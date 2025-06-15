<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPureGoldToReturSalesDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('retur_sales_detail', function (Blueprint $table) {
            $table->decimal('pure_gold', 12, 3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('retur_sales_detail', function (Blueprint $table) {
            $table->dropColumn('pure_gold');
        });
    }
}
