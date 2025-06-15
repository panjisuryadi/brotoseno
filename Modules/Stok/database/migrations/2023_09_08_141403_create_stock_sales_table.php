<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karat_id');
            $table->unsignedBigInteger('sales_id');
            $table->decimal('weight', 5, 2)->default(0.01)->nullable();
            $table->timestamps();
            $table->foreign('karat_id')->references('id')->on('karats');
            $table->foreign('sales_id')->references('id')->on('datasales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_sales');
    }
}
