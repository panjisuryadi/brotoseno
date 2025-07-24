<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCicilToSalesGoldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_gold', function (Blueprint $table) {
            $table->integer('cicil')->default(0)->after('cc_up');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_gold', function (Blueprint $table) {
            $table->dropColumn('cicil');
        });
    }
}
