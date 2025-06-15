<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSomeColumnsToBuysbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buysbacks', function (Blueprint $table) {
            $table->after('note', function(Blueprint $table){
                $table->string('no_buy_back');
                $table->string('product_name');
                $table->unsignedBigInteger('karat_id');
                $table->decimal('weight', 12, 3, true)->default(0);
                $table->unsignedBigInteger('nominal');
                $table->foreign('karat_id')->references('id')->on('karats');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buysbacks', function (Blueprint $table) {
            $table->dropColumn('no_buy_back');
            $table->dropColumn('product_name');
            $table->dropConstrainedForeignId('karat_id');
            $table->dropColumn('weight', 12, 3, true)->default(0);
            $table->dropColumn('nominal');
        });
    }
}
