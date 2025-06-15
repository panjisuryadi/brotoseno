<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuybackNotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyback_nota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cabang_id')->constrained('cabangs');
            $table->foreignId('status_id')->nullable()->constrained('buyback_nota_status');
            $table->foreignId('kategori_produk_id')->constrained('kategoriproduks');
            $table->foreignId('pic_id')->constrained('users');
            $table->string('no_invoice');
            $table->date('date');
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
        Schema::dropIfExists('buyback_nota');
    }
}
