<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockRongsokHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_rongsok_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_rongsok_id')->constrained('stock_rongsok');
            $table->morphs('transaction');
            $table->foreignId('karat_id')->constrained('karats');
            $table->foreignId('sales_id')->nullable()->constrained('datasales');
            $table->decimal('weight',12,3);
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
        Schema::dropIfExists('stock_rongsok_history');
    }
}
