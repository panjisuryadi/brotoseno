<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockPendingHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_pending_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_pending_id')->constrained('stock_pending');
            $table->morphs('transaction');
            $table->boolean('in');
            $table->foreignId('karat_id')->constrained('karats');
            $table->foreignId('cabang_id')->constrained('cabangs');
            $table->double('berat_real',12,3);
            $table->double('berat_kotor',12,3);
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
        Schema::dropIfExists('stock_pending_history');
    }
}
