<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockSalesHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_sales_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_sales_id')->constrained('stock_sales');
            $table->morphs('transaction');
            $table->boolean('in');
            $table->foreignId('karat_id')->constrained('karats');
            $table->foreignId('sales_id')->constrained('datasales');
            $table->decimal('berat_real',12,3);
            $table->decimal('berat_kotor',12,3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_sales_history');
    }
}
