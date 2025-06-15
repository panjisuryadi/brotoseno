<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class CreateDistSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('dist_sales');
        Schema::create('dist_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('goodsreceipt_id');
            $table->unsignedBigInteger('sales_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('date')->nullable();
            $table->integer('no_invoice')->nullable();
            $table->integer('jumlah')->nullable();
            $table->integer('diskon')->nullable();
            $table->integer('total')->nullable();
            $table->string('nama_sales')->nullable();

            $table->foreign('sales_id')->references('id')
             ->on('datasales');

             $table->foreign('user_id')->references('id')
             ->on('users');

             $table->foreign('goodsreceipt_id')->references('id')
             ->on('goodsreceipts')->onDelete('cascade');

          

             $table->timestamps();
        });
         DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dist_sales');
    }
}
