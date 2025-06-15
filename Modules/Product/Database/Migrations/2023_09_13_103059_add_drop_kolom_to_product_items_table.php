<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class AddDropKolomToProductItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_items', function (Blueprint $table) {
               // $table->dropColumn('round_id');
               // $table->dropColumn('location_id');
               // $table->dropColumn('color_id');
               // $table->dropColumn('clarity_id');

               // $table->foreign('cabang_id')->references('id')->on('cabangs');
      
               // $table->foreign('karat_id')->references('id')->on('karats');

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

        });
    }
}
