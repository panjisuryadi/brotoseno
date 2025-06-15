<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddSalesIdAndTypeToStockPendingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::table('stock_pending', function (Blueprint $table) {
            $table->after('cabang_id', function (Blueprint $table){
                $table->unsignedBigInteger('sales_id')->nullable();
                $table->enum('type',['buyback','barangluar']);
                $table->foreign('sales_id')->references('id')->on('datasales');
            });
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::table('stock_pending', function (Blueprint $table) {
            $table->dropConstrainedForeignId('sales_id');
            $table->dropColumn('type');
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
