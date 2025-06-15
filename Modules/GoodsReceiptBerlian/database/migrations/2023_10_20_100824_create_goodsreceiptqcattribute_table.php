<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsreceiptqcattributeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::dropIfExists('goodsreceiptqcattribute');
        Schema::create('goodsreceiptqcattribute', function (Blueprint $table) {
            $table->id();
            $table->integer('goodsreceipt_id');
            $table->integer('attributesqc_id');
            $table->string('keterangan');
            $table->string('note');
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
        Schema::dropIfExists('goodsreceiptqcattribute');
    }
}
