<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetPaidamountDueamountAndStatusPaymentstatusPaymentmethodAsNullableToSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->integer('paid_amount')->nullable()->change();
            $table->integer('due_amount')->nullable()->change();
            $table->string('status')->nullable()->change();
            $table->string('payment_status')->nullable()->change();
            $table->string('payment_method')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->integer('paid_amount')->nullable(false)->change();
        $table->integer('due_amount')->nullable(false)->change();
        $table->string('status')->nullable(false)->change();
        $table->string('payment_status')->nullable(false)->change();
        $table->string('payment_method')->nullable(false)->change();
    }
}
