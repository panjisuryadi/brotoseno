<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class AddNewForeignProdukIdToProductItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (app()->environment() !== 'testing') {
            Schema::table('product_items', function (Blueprint $table) {
              DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    
              
             $table->foreign('product_id')->references('id')
                      ->on('products')->onDelete('cascade');
    
    
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');   
    
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
        Schema::table('product_items', function (Blueprint $table) {

        });
    }
}
