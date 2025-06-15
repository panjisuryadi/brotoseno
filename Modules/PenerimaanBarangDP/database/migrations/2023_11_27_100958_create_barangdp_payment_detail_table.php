<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarangdpPaymentDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangdp_payment_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained('penerimaan_barang_dp_payment');
            $table->tinyInteger('order_number');
            $table->date('due_date')->nullable();
            $table->date('paid_date')->nullable();
            $table->bigInteger('nominal')->nullable();
            $table->integer('box_fee')->nullable();
            $table->foreignId('pic_id')->nullable()->constrained('users');
            $table->unique(['payment_id','order_number']);
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
        Schema::dropIfExists('barangdp_payment_detail');
    }
}
