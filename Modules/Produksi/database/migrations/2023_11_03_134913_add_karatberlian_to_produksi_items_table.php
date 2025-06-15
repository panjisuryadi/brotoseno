<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKaratberlianToProduksiItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produksi_items', function (Blueprint $table) {
            $table->decimal('karatberlians_id')->change();
            $table->renameColumn('karatberlians_id', 'karatberlians');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produksi_items', function (Blueprint $table) {

        });
    }
}
