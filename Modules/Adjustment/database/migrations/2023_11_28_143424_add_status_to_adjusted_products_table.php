<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToAdjustedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adjusted_products', function (Blueprint $table) {
            $table->tinyInteger('status')->nullable(); // 1 success 2 failed
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adjusted_products', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
