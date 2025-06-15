<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFinalToPettyCashTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('petty_cash', function (Blueprint $table) {
            $table->integer('final')->default(0); // Add the 'final' column with default value 0
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('petty_cash', function (Blueprint $table) {
            $table->dropColumn('final'); // Remove the 'final' column
        });
    }
}
