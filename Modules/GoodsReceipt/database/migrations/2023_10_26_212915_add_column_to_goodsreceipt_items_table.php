<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToGoodsreceiptItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goodsreceipt_items', function (Blueprint $table) {
            $table->integer('karatberlians_id')->nullable(); //foreign manual ke table karatberlians
            $table->integer('qty')->nullable();
            $table->integer('shapeberlian_id')->nullable(); // foreign manual ke table shapeberlians
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('goodsreceipt_items', function (Blueprint $table) {
            $table->dropColumn('karatberlians_id');
            $table->dropColumn('qty');
            $table->dropColumn('shapeberlian_id');
        });
    }
}
