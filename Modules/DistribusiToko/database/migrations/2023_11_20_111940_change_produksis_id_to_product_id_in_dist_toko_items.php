<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeProduksisIdToProductIdInDistTokoItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dist_toko_items', function (Blueprint $table) {
            $table->integer('product_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dist_toko_items', function (Blueprint $table) {
            $table->dropColumn('product_id');
        });
        
    }
}
