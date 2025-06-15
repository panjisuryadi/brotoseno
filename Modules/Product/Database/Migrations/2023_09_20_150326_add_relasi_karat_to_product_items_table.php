<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class AddRelasiKaratTooProductItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::table('products', function (Blueprint $table) {
             //If the id column exists on tests table
            if (Schema::hasColumn('products',
                                    'product_quantity',
                                    'product_tax_type',
                                    'product_cost',
                                    'kode_pembelian',
                                    'kode_buys_back',
                                     'id')){
                Schema::table('products', function (Blueprint $table) {
                 DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                 $table->dropColumn('product_quantity');
                 $table->dropColumn('product_tax_type');
                 $table->dropColumn('product_cost');
                 $table->dropColumn('kode_pembelian');
                 $table->dropColumn('kode_buys_back');
                 $table->dropColumn('product_price');
                 $table->dropColumn('product_stock_alert');
                 $table->dropColumn('product_order_tax');
                 $table->dropForeign('products_goodsreceipt_id_foreign');
                 $table->dropColumn('goodsreceipt_id');
                 DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                });

            }
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('_product_items', function (Blueprint $table) {

        // });
    }
}
