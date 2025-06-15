<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeAllPriceToSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{

  Schema::table('sale_details', function (Blueprint $table) {
  DB::statement('alter table sale_details modify price DOUBLE(18,2) DEFAULT 0');
  DB::statement('alter table sale_details modify sub_total DOUBLE(18,2) DEFAULT 0');

    });


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
