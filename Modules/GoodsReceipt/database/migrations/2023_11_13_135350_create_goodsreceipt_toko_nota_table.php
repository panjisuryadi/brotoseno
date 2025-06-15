<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsreceiptTokoNotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goodsreceipt_toko_nota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cabang_id')->constrained('cabangs');
            $table->foreignId('status_id')->constrained('tracking_status');
            $table->foreignId('kategori_produk_id')->constrained('kategoriproduks');
            $table->foreignId('pic_id')->constrained('users');
            $table->string('invoice');
            $table->date('date');
            $table->text('note')->nullable();
            $table->unsignedInteger('invoice_number')->nullable();
            $table->string('invoice_series')->nullable();
            $table->unique(['invoice_series','invoice_number']);
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
        Schema::dropIfExists('goodsreceipt_toko_nota');
    }
}
