<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKaratToHistoryPenentuanHargaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_penentuan_harga', function (Blueprint $table) {
            $table->unsignedBigInteger('karat_id')->nullable()->after('user_id');
            $table->foreign('karat_id')->references('id')->on('karats');
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
