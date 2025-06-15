<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsLunasAndUpdateTipePembayaranToPenerimaanBarangDpPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penerimaan_barang_dp_payment', function (Blueprint $table) {
            $table->tinyInteger('type')->nullable();
            $table->boolean('is_lunas')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penerimaan_barang_dp_payment', function (Blueprint $table) {
            $table->dropColumn(['type','is_lunas']);
        });
    }
}
