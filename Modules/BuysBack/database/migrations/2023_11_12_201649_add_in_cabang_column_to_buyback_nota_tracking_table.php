<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInCabangColumnToBuybackNotaTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buyback_nota_tracking', function (Blueprint $table) {
            $table->boolean('in_cabang')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buyback_nota_tracking', function (Blueprint $table) {
            $table->dropColumn('in_cabang');
        });
    }
}
