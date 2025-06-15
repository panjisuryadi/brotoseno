<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGoodsreceiptIdToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
           $table->unsignedBigInteger('goodsreceipt_id')
           ->nullable()->after('category_id');
           $table->foreign('goodsreceipt_id')->references('id')
           ->on('goodsreceipts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
               $table->dropColumn('goodsreceipt_id');
        });
    }
}
