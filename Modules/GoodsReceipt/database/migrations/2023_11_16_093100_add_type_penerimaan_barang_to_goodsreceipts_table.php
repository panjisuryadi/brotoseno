<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypePenerimaanBarangToGoodsreceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goodsreceipts', function (Blueprint $table) {
            $table->tinyInteger('tipe_penerimaan_barang')->nullable()->comment('saat ini dipakai oleh penerimaan berlian 1 pcs 2 mata tabur');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('goodsreceipts', function (Blueprint $table) {
            $table->dropColumn('tipe_penerimaan_barang');
        });
    }
}
