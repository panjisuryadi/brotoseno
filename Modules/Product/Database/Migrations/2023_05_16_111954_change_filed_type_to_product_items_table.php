<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFiledTypeToProductItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('product_items', function (Blueprint $table) {
         $table->unsignedBigInteger('karat_id')->nullable()->change();
         $table->unsignedBigInteger('certificate_id')->nullable()->change();
         $table->unsignedBigInteger('shape_id')->nullable()->change();
         $table->unsignedBigInteger('round_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
