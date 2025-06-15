<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMarginToKaratsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('karats', function (Blueprint $table) {
            $table->integer('margin')->default(0);  // Adding 'margin' column with default value 0
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('karats', function (Blueprint $table) {
            $table->dropColumn('margin');  // Drop the 'margin' column when rolling back
        });
    }
}
