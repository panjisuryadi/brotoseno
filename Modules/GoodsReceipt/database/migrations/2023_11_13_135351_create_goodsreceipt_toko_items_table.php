<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsreceiptTokoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goodsreceipt_toko_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('cabang_id')->constrained('cabangs');
            $table->foreignId('customer_id')->nullable()->constrained('customers');
            $table->string('customer')->nullable();
            $table->foreignId('goodsreceipt_toko_nota_id')->nullable()->constrained('goodsreceipt_toko_nota');
            $table->foreignId('pic_id')->constrained('users');
            $table->unsignedInteger('nominal');
            $table->text('note')->nullable();
            $table->date('date');
            $table->tinyInteger('type');
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
        Schema::dropIfExists('goodsreceipt_toko_items');
    }
}
