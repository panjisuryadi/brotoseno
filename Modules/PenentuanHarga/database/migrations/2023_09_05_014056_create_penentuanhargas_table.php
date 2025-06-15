<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('penentuanhargas');
        Schema::create('penentuanhargas', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('karat_id');   
            $table->unsignedBigInteger('user_id');   
            $table->date('tgl_update')->nullable();
            $table->integer('harga_emas');
            $table->integer('harga_modal');
            $table->integer('margin');
            $table->integer('harga_jual');
            $table->timestamps();
            $table->foreign('karat_id')->references('id')->on('karats');
            $table->foreign('user_id')->references('id')->on('users');
          });
          DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('penentuanhargas');
    }
};
