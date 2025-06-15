<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusIdToGoodsreceiptTokoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goodsreceipt_toko_items', function (Blueprint $table) {
            $table->unsignedTinyInteger('status_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('goodsreceipt_toko_items', function (Blueprint $table) {
            $table->dropColumn('status_id');
        });
    }
}
