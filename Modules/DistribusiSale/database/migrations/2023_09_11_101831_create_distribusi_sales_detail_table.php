<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistribusiSalesDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distribusi_sales_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('distribusi_sales_id');
            $table->unsignedBigInteger('karat_id');
            $table->decimal('berat_kotor', 12, 3)->default(0.001);
            $table->decimal('berat_bersih', 12, 3)->default(0.001);
            $table->decimal('jumlah', 12, 3)->default(0.001);
            $table->timestamps();

            $table->foreign('distribusi_sales_id')->references('id')->on('history_distribusi_sales')->onDelete('cascade');

             $table->foreign('karat_id')->references('id')->on('karats');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distribusi_sales_detail');
    }
}
