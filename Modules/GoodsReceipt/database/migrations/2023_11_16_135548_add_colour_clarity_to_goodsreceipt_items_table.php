<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColourClarityToGoodsreceiptItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goodsreceipt_items', function (Blueprint $table) {
            $table->string('colour')->nullable()->comment('dibuat untuk keperluan berlian');
            $table->string('clarity')->nullable()->comment('dibuat untuk keperluan berlian');
            $table->string('harga_beli')->nullable()->comment('dibuat untuk keperluan berlian');
            $table->string('currency_id')->nullable()->comment('dibuat untuk keperluan berlian');
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
            $table->dropColumn('colour');
            $table->dropColumn('clarity');
            $table->dropColumn('harga_beli');
            $table->dropColumn('currency_id');
        });
    }
}
