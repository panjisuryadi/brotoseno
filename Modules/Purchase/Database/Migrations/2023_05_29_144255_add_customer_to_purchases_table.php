<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddCustomerToPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchases', function (Blueprint $table) {
           DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $table->unsignedBigInteger('customer_id')->nullable()->after('supplier_id');
            $table->string('customer_name')->nullable()->after('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchases', function (Blueprint $table) {
              $table->unsignedBigInteger('customer_id');
        });
    }
}

