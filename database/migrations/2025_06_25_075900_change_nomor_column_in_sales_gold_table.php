<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNomorColumnInSalesGoldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_gold', function (Blueprint $table) {
            $table->string('nomor', 20)->change(); // Change to VARCHAR(20)
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
            // Adjust this to the original definition, for rollback
            $table->string('nomor')->change(); // or whatever the original was
        });
    }
}
