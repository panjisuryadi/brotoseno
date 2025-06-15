<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenerimaanBarangDpPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penerimaan_barang_dp_payment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penerimaan_barang_dp_id');
             $table->string('tipe_pembayaran');
             $table->string('lunas')->nullable();
             $table->tinyInteger('cicil')->default(0);
             $table->date('jatuh_tempo')->nullable();
             $table->foreign('penerimaan_barang_dp_id')->references('id')->on('penerimaanbarangdps')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penerimaan_barang_dp_payment');
    }
}
