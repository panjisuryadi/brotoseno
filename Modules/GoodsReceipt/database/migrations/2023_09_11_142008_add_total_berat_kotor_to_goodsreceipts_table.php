<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class AddTotalBeratKotorToGoodsreceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
         Schema::table('goodsreceipts', function (Blueprint $table) {
          $table->decimal('total_berat_kotor', 12, 3)->default(0.001)
          ->after('no_invoice');  
          $table->decimal('berat_timbangan', 12, 3)->default(0.001)
          ->after('total_berat_kotor');
           $table->dropColumn('berat_kotor');
           $table->dropColumn('berat_real');
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
        Schema::table('goodsreceipts', function (Blueprint $table) {

        });
    }
}
