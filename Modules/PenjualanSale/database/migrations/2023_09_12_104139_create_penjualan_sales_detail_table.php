<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenjualanSalesDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_sales_detail', function (Blueprint $table) {
            $table->unsignedBigInteger('penjualan_sales_id');
            $table->unsignedBigInteger('karat_id');
            $table->decimal('weight', 12, 3)->default(0.001);
            $table->decimal('nominal', 12, 2)->default(0.01);
            $table->string('created_by')->nullable();
            $table->timestamps();
            
            $table->foreign('penjualan_sales_id')->references('id')->on('penjualan_sales');
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
        Schema::dropIfExists('penjualan_sales_detail');
    }
}
