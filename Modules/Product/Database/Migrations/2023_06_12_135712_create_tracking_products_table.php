<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackingProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
             $table->text('note')->nullable();
            $table->string('username')->nullable();
            $table->integer('status')->default(0)->nullable();

            $table->foreign('product_id')->references('id')
             ->on('products')->nullOnDelete();

             $table->foreign('location_id')->references('id')
             ->on('locations')->nullOnDelete();

            $table->foreign('user_id')->references('id')
            ->on('users')->nullOnDelete();
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
        Schema::dropIfExists('tracking_products');
    }
}
