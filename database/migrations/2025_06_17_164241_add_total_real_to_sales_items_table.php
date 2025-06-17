<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalRealToSalesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('sales_items', function (Blueprint $table) {
        $table->integer('total_real')->default(0)->after('total');
    });
}

public function down()
{
    Schema::table('sales_items', function (Blueprint $table) {
        $table->dropColumn('total_real');
    });
}
}
