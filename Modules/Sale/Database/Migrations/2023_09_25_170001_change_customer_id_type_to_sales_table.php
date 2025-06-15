<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class ChangeCustomerIdTypeToSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (app()->environment() !== 'testing') {
        Schema::table('sales', function (Blueprint $table) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');          
            $table->foreign('customer_id')->references('id')->on('customers');
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');   
            
             });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
