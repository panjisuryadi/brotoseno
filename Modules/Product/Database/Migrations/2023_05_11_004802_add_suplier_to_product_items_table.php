<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class AddSuplierToProductItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {

        Schema::table('product_items', function (Blueprint $table) {
             DB::statement('SET FOREIGN_KEY_CHECKS=0;');
              // $table->dropForeign(['supplier_id']);
              //$table->dropForeign(['etalase_id']);
              // $table->dropColumn('supplier_id');
              // $table->dropColumn('etalase_id');
              //$table->dropColumn('gudang_id');
              // $table->dropColumn('baki_id');
             $table->unsignedBigInteger('supplier_id')->nullable()->after('round_id');
             $table->unsignedBigInteger('etalase_id')->after('supplier_id')->nullable();
             $table->unsignedBigInteger('gudang_id')->after('etalase_id')->nullable();
             $table->unsignedBigInteger('baki_id')->after('gudang_id')->nullable();
             $table->foreign('supplier_id')->references('id')->on('suppliers');
             $table->foreign('etalase_id')->references('id')->on('dataetalases');
             $table->foreign('gudang_id')->references('id')->on('gudangs');
             $table->foreign('baki_id')->references('id')->on('bakis');
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
        Schema::table('product_items', function (Blueprint $table) {
               $table->unsignedBigInteger('supplier_id');
               $table->unsignedBigInteger('etalase_id');
               $table->unsignedBigInteger('baki_id');
               $table->unsignedBigInteger('gudang_id');
        });
    }
}
