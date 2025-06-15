<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsreceiptTokoNotaTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goodsreceipt_toko_nota_tracking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('goodsreceipt_toko_nota_id')->constrained('goodsreceipt_toko_nota')->name('fk_gr_toko_nota');
            $table->foreignId('status_id')->constrained('tracking_status');
            $table->foreignId('cabang_id')->nullable()->constrained('cabangs');
            $table->foreignId('pic_id')->constrained('users');
            $table->text('note')->nullable();
            $table->dateTime('date');
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
        Schema::dropIfExists('goodsreceipt_toko_nota_tracking');
    }
}
