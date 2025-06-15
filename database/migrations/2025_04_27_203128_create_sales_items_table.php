<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_items', function (Blueprint $table) {
            $table->id();  // Creates an auto-increment primary key column 'id'
            $table->integer('product');  // Integer column 'product'
            $table->string('name', 255);  // String column 'name' with a max length of 255
            $table->string('desc', 255);  // String column 'desc' with a max length of 255
            $table->integer('total');  // Integer column 'total'
            $table->timestamps();  // Adds 'created_at' and 'updated_at' columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_items');
    }
}
