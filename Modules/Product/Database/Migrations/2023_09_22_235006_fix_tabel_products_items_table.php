<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class FixTabelProductsItemsTable extends Migration
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
                // $table->dropColumn('shape_id');
                 //$table->dropColumn('product_price');
                 //$table->dropColumn('product_cost');
                 //$table->dropColumn('product_sale');
                // $table->dropColumn('gudang');
                 //$table->dropColumn('brankas');
                // $table->dropColumn('margin');
                 //$table->dropColumn('clarity_id');
                 //$table->dropForeign('product_items_clarity_id_foreign');
                 //$table->dropForeign('product_items_color_id_foreign');
                // $table->dropColumn('color_id');
                 //$table->dropForeign('product_items_gudang_id_foreign');
                // $table->dropColumn('gudang_id');
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
        //
    }
}
