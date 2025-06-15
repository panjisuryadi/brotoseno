<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalKaratToGoodsreceiptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goodsreceipts', function (Blueprint $table) {
            $table->float('total_karat')->nullable(); // untuk menanmpung total karat berlian yang diinput langsung
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('goodsreceipts', function (Blueprint $table) {
            $table->dropColumn('total_karat');
        });
    }
}
