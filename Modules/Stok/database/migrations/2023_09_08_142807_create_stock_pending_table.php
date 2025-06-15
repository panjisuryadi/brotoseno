<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockPendingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_pending', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karat_id');
            $table->unsignedBigInteger('cabang_id');
            $table->decimal('weight', 5, 2)->default(0.01)->nullable();
            $table->timestamps();
            $table->foreign('cabang_id')->references('id')->on('cabangs');
            $table->foreign('karat_id')->references('id')->on('karats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_pending');
    }
}
