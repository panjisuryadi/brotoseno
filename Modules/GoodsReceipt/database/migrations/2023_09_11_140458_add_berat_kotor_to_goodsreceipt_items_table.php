<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class AddBeratKotorToGoodsreceiptItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         DB::statement('SET FOREIGN_KEY_CHECKS=0;');
         Schema::table('goodsreceipt_items', function (Blueprint $table) {
          $table->decimal('berat_real', 12, 3)->default(0.001)
          ->after('kategoriproduk_id');  
          $table->decimal('berat_kotor', 12, 3)->default(0.001)
          ->after('berat_real');
           $table->dropColumn('qty');
           $table->dropColumn('kadar');
        });
         DB::statement('SET FOREIGN_KEY_CHECKS=1;');
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
