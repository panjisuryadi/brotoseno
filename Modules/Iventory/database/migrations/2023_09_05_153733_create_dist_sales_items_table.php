<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class CreateDistSalesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('dist_sales_items');
        Schema::create('dist_sales_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dist_sales_id');
            $table->integer('berat_kotor')->nullable();
            $table->integer('berat_bersih')->nullable();
            $table->integer('jumlah')->nullable();
            $table->string('no_nota')->nullable();
            $table->string('nomor_pembelian')->nullable();
            $table->string('karat')->nullable();


            $table->timestamps();

             $table->foreign('dist_sales_id')->references('id')
             ->on('dist_sales')->onDelete('cascade');
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
        Schema::dropIfExists('dist_sales_items');
    }
}
