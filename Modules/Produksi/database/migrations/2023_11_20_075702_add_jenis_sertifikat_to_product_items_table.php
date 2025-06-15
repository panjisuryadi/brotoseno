<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJenisSertifikatToProductItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_items', function (Blueprint $table) {
            $table->string('jenis_sertifikat')->nullable();
            $table->integer('goodsreceipt_item_id')->nullable();
            $table->json('additional_data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_items', function (Blueprint $table) {
            $table->dropColumn('jenis_sertifikat');
            $table->dropColumn('additional_data');
            $table->dropColumn('goodsreceipt_item_id');
        });
    }
}
