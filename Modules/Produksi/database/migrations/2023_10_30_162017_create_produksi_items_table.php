<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduksiItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produksi_items', function (Blueprint $table) {
            $table->id();
            $table->integer('produksis_id'); //foreign manual ke table 
            $table->integer('karatberlians_id'); //foreign manual ke table 
            $table->integer('qty')->default(0);
            $table->integer('shapeberlian_id')->nullable(); // foreign manual ke table shapeberlians
            $table->integer('kategoriproduk_id')->nullable(); // foreign manual ke table kategoriproduk
            $table->string('keterangan')->nullable();
            $table->boolean('is_deleted')->default(false);
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
        Schema::dropIfExists('produksi_items');
    }
}
