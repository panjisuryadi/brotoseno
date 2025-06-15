<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePiutangSalesReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('piutang_sales_report', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('karat_id');
            $table->unsignedBigInteger('sales_id');
            $table->text('description');
            $table->decimal('weight_in', 12, 3, true)->nullable();
            $table->decimal('weight_out', 12, 3, true)->nullable();
            $table->decimal('remaining_weight', 12, 3, true);

            $table->foreign('karat_id')->references('id')->on('karats');
            $table->foreign('sales_id')->references('id')->on('datasales');
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
        Schema::dropIfExists('piutang_sales_report');
    }
}
