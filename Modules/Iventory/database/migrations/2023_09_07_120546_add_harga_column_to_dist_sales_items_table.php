<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHargaColumnToDistSalesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dist_sales_items', function (Blueprint $table) {
            $table->decimal('harga',4,2)->nullable()->after('nomor_pembelian');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dist_sales_items', function (Blueprint $table) {
            $table->dropColumn('harga');
        });
    }
}
