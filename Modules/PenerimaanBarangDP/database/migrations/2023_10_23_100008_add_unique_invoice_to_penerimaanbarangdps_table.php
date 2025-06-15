<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniqueInvoiceToPenerimaanbarangdpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penerimaanbarangdps', function (Blueprint $table) {
            $table->unique(['no_barang_dp']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penerimaanbarangdps', function (Blueprint $table) {
            $table->dropUnique(['no_barang_dp']);
        });
    }
}
