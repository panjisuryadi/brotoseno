<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeBeratRealAndBeratKotorLengthToStockOfficeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_office', function (Blueprint $table) {
            $table->decimal('berat_real', 12, 3)->default(0)
            ->nullable()->change();
             $table->decimal('berat_kotor', 12, 3)->default(0)
            ->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_office', function (Blueprint $table) {
            $table->decimal('berat_real', 5, 3)->default(0)
            ->nullable()->change();
             $table->decimal('berat_kotor', 5, 3)->default(0)
            ->nullable()->change();
        });
    }
}
