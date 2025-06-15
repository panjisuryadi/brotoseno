<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */


    public function up()
    {
        Schema::create('product_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedInteger('karat_id');
            $table->unsignedInteger('certificate_id');
            $table->unsignedInteger('shape_id');
            $table->unsignedInteger('round_id');
            $table->integer('product_price');
            $table->integer('product_cost');
            $table->integer('product_sale');
            $table->integer('berat_emas')->nullable();
            $table->integer('berat_accessories')->nullable();
            $table->integer('berat_label')->nullable();
            $table->integer('berat_total')->nullable();
            $table->string('gudang')->nullable();
            $table->string('brankas')->nullable();
            $table->string('kode_baki')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('product_items');
    }
}
