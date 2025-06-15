<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsreceiptqcitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goodsreceiptqcitems', function (Blueprint $table) {
            $table->id();
            $table->integer('goodsreceipt_id'); //foreign manual ke table goodsreceipt
            $table->integer('karatberlians_id'); //foreign manual ke table karatberlians
            $table->integer('qty')->default(0);
            $table->integer('shapeberlian_id')->nullable(); // foreign manual ke table shapeberlians
            $table->string('keterangan')->nullable();
            $table->boolean('is_deleted')->default(false);
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
        Schema::dropIfExists('goodsreceiptqcitems');
    }
}
