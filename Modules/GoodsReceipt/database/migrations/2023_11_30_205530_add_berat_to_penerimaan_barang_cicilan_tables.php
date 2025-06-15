<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBeratToPenerimaanBarangCicilanTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penerimaan_barang_cicilan', function (Blueprint $table) {
            $table->decimal('nominal', 12,3,true)->nullable();
            $table->decimal('jumlah_cicilan', 12,3,true)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penerimaan_barang_cicilan', function (Blueprint $table) {
            $table->dropColumn('nominal');
        });
    }
}
