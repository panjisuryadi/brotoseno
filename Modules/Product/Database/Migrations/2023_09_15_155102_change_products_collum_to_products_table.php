<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeProductsCollumToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
  
        if (Schema::hasColumn('products',
                        'product_quantity',
                        'product_tax_type')){

            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('product_quantity');
                $table->dropColumn('product_tax_type');
            });
        }
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
