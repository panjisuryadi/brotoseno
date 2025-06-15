<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturPembelianDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returpembelians_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('retur_pembelian_id')->constrained('returpembelians');
            $table->foreignId('karat_id')->constrained('karats');
            $table->decimal('weight', 12,3, true)->nullable();
            $table->decimal('harga')->nullable();
            $table->decimal('pure_gold', 12,3, true)->nullable();
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
        Schema::dropIfExists('returpembelians_detail');
    }
}
