<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePettyCashsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petty_cashs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->default(DB::raw('CURRENT_DATE')); // tanggal DATE DEFAULT CURRENT_DATE
            $table->integer('current');  // current INT
            $table->integer('cash_in');  // cash_in INT
            $table->integer('cash_out'); // cash_out INT
            $table->integer('final');    // final INT
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('petty_cashs');
    }
}
