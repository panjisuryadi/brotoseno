<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKaratberlianIdToProductItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_items', function (Blueprint $table) {
            $table->unsignedBigInteger('karat_berlian_id')->nullable()->after('gold_kategori_id');
             $table->foreign('karat_berlian_id')->references('id')->on('karatberlians');
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
                $table->dropColumn('karat_berlian_id');
        });
    }
}
