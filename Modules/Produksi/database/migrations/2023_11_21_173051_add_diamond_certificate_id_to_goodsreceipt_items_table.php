<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDiamondCertificateIdToGoodsreceiptItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goodsreceipt_items', function (Blueprint $table) {
            $table->integer('diamond_certificate_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('goodsreceipt_items', function (Blueprint $table) {
            $table->dropColumn('diamond_certificate_id');
        });
    }
}
