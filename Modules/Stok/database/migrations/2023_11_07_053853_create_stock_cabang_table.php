<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockCabangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_cabang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cabang_id')->constrained('cabangs');
            $table->foreignId('karat_id')->constrained('karats');
            $table->double('berat_real',12,3)->default(0);
            $table->double('berat_kotor',12,3)->default(0);
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
        Schema::dropIfExists('stock_cabang');
    }
}
