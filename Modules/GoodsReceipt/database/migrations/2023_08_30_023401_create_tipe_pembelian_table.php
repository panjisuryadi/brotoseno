<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipePembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipe_pembelian', function (Blueprint $table) {
             $table->id();
             $table->unsignedBigInteger('goodsreceipt_id');
             $table->string('tipe_pembayaran')->nullable();
             $table->string('lunas')->nullable();
             $table->tinyInteger('cicil')->default(0);
             $table->date('jatuh_tempo')->nullable();
             $table->timestamps();

             $table->foreign('goodsreceipt_id')->references('id')->on('goodsreceipts')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipe_pembelian');
    }
}
