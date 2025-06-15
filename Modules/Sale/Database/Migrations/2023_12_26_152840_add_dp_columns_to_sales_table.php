<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDpColumnsToSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->tinyInteger('dp_payment')->default(0)->comment('untuk menampung apakah ini dp atau bukan');
            $table->unsignedBigInteger('dp_nominal')->default(0);
            $table->unsignedBigInteger('remain_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('dp_payment');
            $table->dropColumn('dp_nominal');
            $table->dropColumn('remain_amount');
        });
    }
}
