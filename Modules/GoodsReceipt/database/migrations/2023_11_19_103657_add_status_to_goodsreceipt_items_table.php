<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToGoodsreceiptItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goodsreceipt_items', function (Blueprint $table) {
            $table->tinyInteger('status')->nullable()->default(1);
            $table->decimal('karatberlians_terpakai', 12, 3, true)->default(0);
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
        Schema::table('goodsreceipt_items', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('berat_terpakai');
            $table->dropColumn('additional_data');
        });
    }
}
