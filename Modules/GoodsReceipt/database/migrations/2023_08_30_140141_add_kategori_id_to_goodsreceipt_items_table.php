<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKategoriIdToGoodsreceiptItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goodsreceipt_items', function (Blueprint $table) {
          $table->unsignedBigInteger('kategoriproduk_id')
         ->nullable()->after('kadar');  
          $table->unsignedBigInteger('karat_id')
         ->nullable()->after('kategoriproduk_id');   
          $table->string('qty')->default(0)->nullable()->after('kategoriproduk_id');

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

        });
    }
}
