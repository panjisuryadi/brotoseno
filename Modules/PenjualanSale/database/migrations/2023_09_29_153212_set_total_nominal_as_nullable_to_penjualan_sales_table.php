<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetTotalNominalAsNullableToPenjualanSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penjualan_sales', function (Blueprint $table) {
            $table->decimal('total_nominal', 12, 2)->default(0.01)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penjualan_sales', function (Blueprint $table) {
            $table->decimal('total_nominal', 12, 2)->default(0.01)->nullable(false)->change();
        });
    }
}
