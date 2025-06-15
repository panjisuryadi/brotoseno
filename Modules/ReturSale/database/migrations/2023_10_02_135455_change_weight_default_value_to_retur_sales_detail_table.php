<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeWeightDefaultValueToReturSalesDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('retur_sales_detail', function (Blueprint $table) {
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
        Schema::table('retur_sales_detail', function (Blueprint $table) {
            $table->decimal('weight', 12, 3)->default(0.001)->change();
        });
    }
}
