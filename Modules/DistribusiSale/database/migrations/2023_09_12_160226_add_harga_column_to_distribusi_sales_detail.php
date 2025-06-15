<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHargaColumnToDistribusiSalesDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distribusi_sales_detail', function (Blueprint $table) {
            $table->decimal('harga', 12, 3)->nullable()->after('berat_bersih');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('distribusi_sales_detail', function (Blueprint $table) {
            $table->dropColumn('harga');
        });
    }
}
