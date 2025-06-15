<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetSomeColumnsAsNullableToCustomerSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_sales', function (Blueprint $table) {
            $table->string('customer_email')->nullable()->change();
            $table->string('customer_phone')->nullable()->change();
            $table->string('country')->nullable()->change();
            $table->text('address')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_sales', function (Blueprint $table) {
            $table->string('customer_email')->nullable(false)->change();
            $table->string('customer_phone')->nullable(false)->change();
            $table->string('country')->nullable(false)->change();
            $table->text('address')->nullable(false)->change();
        });
    }
}
