<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalBayarAndTotalQtyToGoodsreceipts extends Migration
{
    public function up()
    {
        Schema::table('goodsreceipts', function (Blueprint $table) {
            // Add new columns here
            $table->integer('total_bayar')->nullable();
            $table->integer('total_qty')->nullable();
        });
    }

    public function down()
    {
        Schema::table('goodsreceipts', function (Blueprint $table) {
            // Remove columns in case we want to rollback
            $table->dropColumn('total_bayar');
            $table->dropColumn('total_qty');
        });
    }

}
