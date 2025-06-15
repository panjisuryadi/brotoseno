<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotesToAdjustedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adjusted_products', function (Blueprint $table) {
            $table->Integer('stock_data')->nullable();
            $table->String('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adjusted_products', function (Blueprint $table) {
            $table->dropColumn('note');
            $table->dropColumn('stock_data');
        });
    }
}
