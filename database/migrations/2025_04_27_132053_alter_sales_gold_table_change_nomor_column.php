<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSalesGoldTableChangeNomorColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_gold', function (Blueprint $table) {
            $table->string('nomor', 10)->change();  // Changing 'nomor' from int to string(10)
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
            $table->integer('nomor')->change();  // Reverting 'nomor' back to integer
        });
    }
}
