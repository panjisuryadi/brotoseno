<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class AddUpdateCollumToProductItemsTable extends Migration
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
            if(Schema::hasColumns('product_items', ['brankas',
                  'shape_id', 
                  'gudang_id', 
                  'round_id', 
                  'baki_id'])) {
              //$table->dropColumn('brankas');
              $table->dropColumn('round_id');
            } else {
              $table->dropColumn(['gudang_id']);  
            //  $table->dropColumn('gudang_id');
              // $table->decimal('berat_emas', 12, 3)->default(0.001)->change();
              // $table->decimal('berat_accessories', 12, 3)->default(0.001)->change();
              // $table->decimal('tag_label', 12, 3)->default(0.001)->change();
              // $table->decimal('berat_label', 12, 3)->default(0.001)->change();
            }
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

        });
    }
}
