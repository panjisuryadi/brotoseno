<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentColumnsToSalesGoldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_gold', function (Blueprint $table) {
            $table->integer('cash')->default(0)->after('total');
            $table->integer('edc')->default(0)->after('cash');
            $table->integer('transfer')->default(0)->after('edc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_gold', function (Blueprint $table) {
            $table->dropColumn(['cash', 'edc', 'transfer']);
        });
    }
}
