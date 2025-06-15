<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockPendingOfficeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_pending_office', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karat_id');
            $table->decimal('weight',12,3,true);
            $table->foreign('karat_id')->references('id')->on('karats');
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
        Schema::dropIfExists('stock_pending_office');
    }
}
