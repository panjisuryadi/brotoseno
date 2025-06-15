<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewcolToProduksiItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produksi_items', function (Blueprint $table) {
            $table->integer('karat_id')->nullable();
            $table->integer('model_id')->nullable();
            $table->decimal('berat_asal_item', 12,3, true)->nullable();
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
            $table->dropColumn('karat_id');
            $table->dropColumn('model_id');
            $table->dropColumn('berat_asal_item');
        });
    }
}
