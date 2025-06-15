<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturSalesDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retur_sales_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('retur_sales_id');
            $table->unsignedBigInteger('karat_id');
            $table->decimal('weight', 12, 3)->default(0.001);
            $table->decimal('nominal', 12, 2)->default(0.01);
            $table->timestamps();
            
            $table->foreign('retur_sales_id')->references('id')->on('retursales')->onDelete('cascade');

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
        Schema::dropIfExists('retur_sales_detail');
    }
}
