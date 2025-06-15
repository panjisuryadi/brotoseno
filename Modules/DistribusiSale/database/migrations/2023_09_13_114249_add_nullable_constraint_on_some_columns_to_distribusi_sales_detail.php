<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullableConstraintOnSomeColumnsToDistribusiSalesDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distribusi_sales_detail', function (Blueprint $table) {
            $table->decimal('berat_kotor', 12, 3)->default(0.001)->nullable()->change();
            $table->decimal('jumlah', 12, 3)->default(0.001)->nullable()->change();
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
            $table->decimal('berat_kotor', 12, 3)->default(0.001)->nullable(false)->change();
            $table->decimal('jumlah', 12, 3)->default(0.001)->nullable(false)->change();
        });
    }
}
