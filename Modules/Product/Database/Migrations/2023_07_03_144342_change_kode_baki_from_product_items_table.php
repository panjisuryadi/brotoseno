<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeKodeBakiFromProductItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     Schema::table('product_items', function (Blueprint $table) {
          $table->dropColumn('kode_baki');
          $table->unsignedBigInteger('color_id')->nullable()->after('clarity_id');
          $table->foreign('color_id')->references('id')->on('itemcolours');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropColumn('kode_baki');
    }
}
