<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPureGoldToDistribusiSalesDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distribusi_sales_detail', function (Blueprint $table) {
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
        Schema::table('distribusi_sales_detail', function (Blueprint $table) {
            $table->dropColumn('pure_gold');
        });
    }
}
