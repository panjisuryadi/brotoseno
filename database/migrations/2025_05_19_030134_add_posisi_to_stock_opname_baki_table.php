<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPosisiToStockOpnameBakiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_opname_baki', function (Blueprint $table) {
            $table->string('posisi', 20)->nullable()->after('baki_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_opname_baki', function (Blueprint $table) {
            $table->dropColumn('posisi');
        });
    }
}
