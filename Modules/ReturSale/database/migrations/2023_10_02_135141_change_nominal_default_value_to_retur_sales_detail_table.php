<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNominalDefaultValueToReturSalesDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('retur_sales_detail', function (Blueprint $table) {
            $table->decimal('nominal', 12, 2)->default(0)->nullable()->change();
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
            $table->decimal('nominal', 12, 2)->default(0.01)->nullable()->change();
        });
    }
}
