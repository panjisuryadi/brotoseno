<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuybackStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyback_statuses', function (Blueprint $table) {
            $table->unsignedBigInteger('buyback_id');
            $table->unsignedBigInteger('status_id');

            $table->foreign('buyback_id')->references('id')->on('buysbacks')->cascadeOnDelete();
            $table->foreign('status_id')->references('id')->on('proses_statuses')->cascadeOnDelete();
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
        Schema::dropIfExists('buyback_statuses');
    }
}
