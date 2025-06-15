<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddCabangToBuysbacksTable extends Migration
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
            $table->after('customer_name', function(Blueprint $table){
                $table->unsignedBigInteger('cabang_id');
                $table->foreign('cabang_id')->references('id')->on('cabangs');
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::table('buysbacks', function (Blueprint $table) {
            $table->dropConstrainedForeignId('cabang_id');
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
