<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeWeightColumnPlaceInStockSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         DB::statement('SET FOREIGN_KEY_CHECKS=0;');
         Schema::table('stock_sales', function (Blueprint $table) {
            $table->decimal('weight', 12, 3)->default(0.000)->nullable()->change();
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
         Schema::table('stock_sales', function (Blueprint $table) {
            $table->decimal('weight', 5, 2)->default(0.01)->nullable()->change();
         });
         DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
