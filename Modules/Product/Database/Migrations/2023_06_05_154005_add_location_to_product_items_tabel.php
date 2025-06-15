<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class AddLocationToProductItemsTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

            Schema::table('product_items', function (Blueprint $table) {

              $table->unsignedBigInteger('location_id')->nullable()->after('baki_id');
              $table->unsignedBigInteger('jenis_perhiasan_id')->nullable()->after('location_id');
              $table->unsignedBigInteger('parameter_berlian_id')->nullable()
              ->after('jenis_perhiasan_id');
              $table->unsignedBigInteger('customer_id')->nullable()->after('supplier_id');

              $table->foreign('location_id')->references('id')->on('locations');
              $table->foreign('customer_id')->references('id')->on('customers');


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
             $table->dropColumn('location_id');
             $table->dropColumn('jenis_perhiasan_id');
             $table->dropColumn('parameter_berlian_id');
             $table->dropColumn('customer_id');
        });
    }
}
