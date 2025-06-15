<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class AddStatusToBuysbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::table('buysbacks', function (Blueprint $table) {
            $table->after('note', function(Blueprint $table){
               $table->string('status')->nullable();
            });
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buysbacks', function (Blueprint $table) {

        });
    }
}
