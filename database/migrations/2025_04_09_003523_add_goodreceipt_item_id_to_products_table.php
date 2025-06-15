<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGoodreceiptItemIdToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Add the new column
            $table->integer('goodreceipt_item_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Rollback the change by removing the new column
            $table->dropColumn('goodreceipt_item_id');
        });
    }

}
