<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class AddCabangToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
         $table->unsignedBigInteger('cabang_id')->nullable()->after('category_id');
         $table->foreign('cabang_id')->references('id')->on('cabangs');
         DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {

        });
    }
}
