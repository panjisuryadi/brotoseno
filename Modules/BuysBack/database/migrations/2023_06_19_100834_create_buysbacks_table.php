<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buysbacks', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('reference');
            $table->string('kode_sales')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('jenis_buyback_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('supplier_name')->nullable();
            $table->integer('tax_percentage')->default(0);
            $table->integer('tax_amount')->default(0);
            $table->integer('discount_percentage')->default(0);
            $table->integer('discount_amount')->default(0);
            $table->integer('shipping_amount')->default(0);
            $table->integer('total_amount');
            $table->integer('paid_amount');
            $table->integer('due_amount');
            $table->string('status')->nullable();
            $table->string('payment_status');
            $table->string('payment_method');
            $table->text('note')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('jenis_buyback_id')->references('id')->on('jenisbuybacks');
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
        Schema::dropIfExists('buysbacks');
    }
};
