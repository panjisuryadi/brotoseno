<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryPenentuanHargaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_penentuan_harga', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penentuan_harga_id');   
            $table->unsignedBigInteger('user_id');   
            $table->datetime('tanggal')->nullable();
            $table->integer('harga_emas')->nullable();
            $table->integer('updated')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
            $table->foreign('penentuan_harga_id')->references('id')->on('penentuanhargas')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_penentuan_harga');
    }
}
