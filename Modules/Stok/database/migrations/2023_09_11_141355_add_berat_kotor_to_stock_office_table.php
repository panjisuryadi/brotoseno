<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class AddBeratKotorToStockOfficeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         DB::statement('SET FOREIGN_KEY_CHECKS=0;');
         Schema::table('stock_office', function (Blueprint $table) {
            $table->decimal('berat_real', 5, 3)->default(0.001)
            ->nullable()->after('karat_id');
             $table->decimal('berat_kotor', 5, 3)->default(0.001)
            ->nullable()->after('berat_real');
              $table->dropColumn('weight');
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
        Schema::table('stock_office', function (Blueprint $table) {

        });
    }
}
