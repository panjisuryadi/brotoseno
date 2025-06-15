<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessoriesBerlianDetailM extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accessories_berlian_details', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->nullable();
            $table->tinyInteger('accessories_id')->nullable();
            $table->string('klasifikasi_berlian')->nullable();
            $table->tinyInteger('shapeberlian_id')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('colour')->nullable();
            $table->string('clarity')->nullable();
            $table->integer('diamond_certificate_id')->nullable();

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
        Schema::dropIfExists('accessories_berlian_details');
    }
}
