<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomsManual extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customs_manual', function (Blueprint $table) {
            $table->id();
            $table->integer('nominal');
            $table->string('catatan');
            $table->timestamps();
            $table->unsignedBigInteger('customs_id');
            $table->foreign('customs_id')->references('id')->on('customs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customs_manual');
    }
}
