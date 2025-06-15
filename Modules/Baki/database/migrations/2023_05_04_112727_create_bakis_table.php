<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('bakis');
        Schema::create('bakis', function (Blueprint $table) {
           $table->id();
            $table->unsignedBigInteger('gudang_id');
            $table->string('code');
            $table->string('name');
            $table->integer('berat');
            $table->string('bandrol');
            //$table->text('description')->nullable();
            //$table->string('image')->nullable(true);
            $table->foreign('gudang_id')->references('id')->on('gudangs')->restrictOnDelete();
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
        Schema::dropIfExists('bakis');
    }
};
