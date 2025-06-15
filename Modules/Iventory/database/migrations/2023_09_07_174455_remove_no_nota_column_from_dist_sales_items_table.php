<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RemoveNoNotaColumnFromDistSalesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dist_sales_items', function (Blueprint $table) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
          //  $table->dropColumn('no_nota');
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
        Schema::table('dist_sales_items', function (Blueprint $table) {
            $table->string('no_nota')->nullable();
        });
    }
}
