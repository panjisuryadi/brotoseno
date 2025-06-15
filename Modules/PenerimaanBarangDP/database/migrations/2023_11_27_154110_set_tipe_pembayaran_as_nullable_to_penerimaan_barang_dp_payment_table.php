<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetTipePembayaranAsNullableToPenerimaanBarangDpPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penerimaan_barang_dp_payment', function (Blueprint $table) {
            $table->string('tipe_pembayaran')->nullable()->change();
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
            $table->string('tipe_pembayaran')->nullable(false)->change();
        });
    }
}
