<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuybackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyback', function (Blueprint $table) {
            $table->id(); // auto-increment primary key
            $table->string('nota', 255); // kondisi column
            $table->integer('product_id'); // product_id column
            $table->char('status', 1)->default('A'); // status column with a default value of 'A'
            $table->integer('harga'); // harga column
            $table->string('kondisi', 255); // kondisi column
            $table->date('tanggal'); // tanggal column
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buyback');
    }

}
