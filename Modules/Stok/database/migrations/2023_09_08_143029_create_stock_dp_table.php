<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockDpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_dp', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karat_id');
            $table->unsignedBigInteger('cabang_id');
            $table->unsignedBigInteger('customer_id');
            $table->decimal('weight', 5, 2)->default(0.01)->nullable();
            $table->timestamps();
            
            $table->foreign('customer_id')->references('id')->on('customers');
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
        Schema::dropIfExists('stock_dp');
    }
}
