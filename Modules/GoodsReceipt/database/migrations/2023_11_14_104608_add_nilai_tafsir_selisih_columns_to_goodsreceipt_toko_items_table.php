<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNilaiTafsirSelisihColumnsToGoodsreceiptTokoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goodsreceipt_toko_items', function (Blueprint $table) {
            $table->unsignedInteger('nilai_tafsir')->nullable();
            $table->integer('nilai_selisih')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('goodsreceipt_toko_items', function (Blueprint $table) {
            $table->dropColumn(['nilai_tafsir','nilai_selisih']);
        });
    }
}
