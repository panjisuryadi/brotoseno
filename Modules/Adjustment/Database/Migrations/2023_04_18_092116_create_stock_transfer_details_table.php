<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockTransferDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_transfer_details', function (Blueprint $table) {
            $table->id();
            $table->UnsignedBigInteger('stock_transfer_id');
            $table->UnsignedBigInteger('product_id');
            $table->UnsignedBigInteger('origin');
            $table->UnsignedBigInteger('destination');
            $table->Integer('stock_sent');
            $table->String('note')->nullable();
            $table->timestamps();

            
            $table->foreign('stock_transfer_id')->references('id')->on('stock_transfers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_transfer_details');
    }
}
