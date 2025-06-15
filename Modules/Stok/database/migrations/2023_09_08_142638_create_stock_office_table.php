<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockOfficeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_office', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karat_id');
            $table->decimal('weight', 5, 2)->default(0.01)->nullable();
            $table->timestamps();
            
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
        Schema::dropIfExists('stock_office');
    }
}
