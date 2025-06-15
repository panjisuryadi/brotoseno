<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHargaToHistoryPenentuanHargaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_penentuan_harga', function (Blueprint $table) { 
            $table->integer('harga_jual')->nullable()->after('harga_emas');
            $table->integer('harga_modal')->nullable()->after('harga_jual');
            $table->integer('margin')->nullable()->after('harga_modal');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('history_penentuan_harga', function (Blueprint $table) {

        });
    }
}
