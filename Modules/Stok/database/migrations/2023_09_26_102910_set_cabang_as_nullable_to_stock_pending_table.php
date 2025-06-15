<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class SetCabangAsNullableToStockPendingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::table('stock_pending', function (Blueprint $table) {
            $table->unsignedBigInteger('cabang_id')->nullable()->change();
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
        Schema::table('stock_pending', function (Blueprint $table) {
            $table->unsignedBigInteger('cabang_id')->change();
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
