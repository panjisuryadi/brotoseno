<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Customs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customs', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_barang');
            $table->double('berat');
            $table->integer('harga');
            $table->integer('ongkos_produksi');
            $table->integer('ongkos_cuci');
            $table->integer('ongkos_rnk');
            $table->integer('ongkos_mt');
            $table->integer('total');
            $table->double('berat_jadi',12, 3, true)->nullable();
            $table->integer('harga_jual')->nullable();
            $table->date('date')->nullable();
            $table->string('code')->nullable();;
            $table->string('status')->nullable();;
            $table->timestamps();
            $table->unsignedBigInteger('sales_id')->nullable();
            $table->foreign('sales_id')->references('id')->on('sales');
            $table->unsignedBigInteger('cabang_id');
            $table->foreign('cabang_id')->references('id')->on('cabangs');
            $table->unsignedBigInteger('karat_id');
            $table->foreign('karat_id')->references('id')->on('karats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customs');
    }
}
