<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class CreateGoodsreceiptItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('goodsreceipt_items');
        Schema::create('goodsreceipt_items', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('goodsreceipt_id');
            $table->string('kadar')->nullable();
             $table->timestamps();
             $table->foreign('goodsreceipt_id')->references('id')->on('goodsreceipts')->onDelete('cascade');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goodsreceipt_items');
    }
}
