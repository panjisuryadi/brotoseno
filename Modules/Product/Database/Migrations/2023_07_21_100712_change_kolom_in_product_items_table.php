<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class ChangeKolomInProductItemsTable extends Migration
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
              //$table->dropColumn('models_id');
              $table->dropColumn('berat_total');
              $table->dropColumn('berat_accessories');
              $table->dropColumn('berat_label');
              $table->dropColumn('berat_emas');
              // $table->decimal('berat_total', 10, 4)->nullable()->change();
              // $table->decimal('berat_emas', 10, 4)->nullable()->change();
              // $table->decimal('berat_accessories', 10, 4)->nullable()->change();
              // $table->decimal('berat_label', 10, 4)->nullable()->change();
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
         // $table->dropColumn('models_id');
         // $table->dropColumn('berat_total');
         // $table->dropColumn('berat_accessories');
         // $table->dropColumn('berat_label');
         // $table->dropColumn('berat_emas');
    }
}
