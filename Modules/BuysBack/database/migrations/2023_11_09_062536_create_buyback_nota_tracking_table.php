<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuybackNotaTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyback_nota_tracking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyback_nota_id')->constrained('buyback_nota');
            $table->foreignId('status_id')->constrained('buyback_nota_status');
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
        Schema::dropIfExists('buyback_nota_tracking');
    }
}
