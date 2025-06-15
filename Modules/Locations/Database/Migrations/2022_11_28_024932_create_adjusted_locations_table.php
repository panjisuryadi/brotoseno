<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdjustedLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjusted_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('adjustment_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('id_location')->nullable();
            $table->unsignedBigInteger('sub_location')->nullable();
            $table->integer('quantity');
            $table->foreign('adjustment_id')->references('id')->on('adjustments')->onDelete('cascade');
            $table->foreign('id_location')->references('id')->on('locations');
            $table->foreign('sub_location')->references('id')->on('locations');
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
        Schema::dropIfExists('adjusted_locations');
    }
}
