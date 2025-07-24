<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCicilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cicils', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_gold_id');
            $table->unsignedBigInteger('customer_id');
            $table->integer('total_trx');
            $table->integer('paid');
            $table->integer('sisa');
            $table->string('install')->nullable(); // Assuming it's a string field, e.g., "monthly", nullable for safety
            $table->integer('installments')->default(0);
            $table->timestamps();

            $table->foreign('sales_gold_id')->references('id')->on('sales_gold')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cicils');
    }
}
