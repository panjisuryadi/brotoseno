<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWeightNullableToStockRongsokTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_rongsok', function (Blueprint $table) {
            $table->decimal('weight',12,3)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_rongsok', function (Blueprint $table) {
            $table->decimal('weight',12,3)->nullable(false)->change();
        });
    }
}
