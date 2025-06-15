<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnToKaratberliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('karatberlians', function (Blueprint $table) {
            $table->renameColumn('code', 'karat');
            $table->float('size')->nullable();
            $table->dropColumn('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('karatberlians', function (Blueprint $table) {
            $table->renameColumn('karat', 'code');
            $table->dropColumn('size');
            $table->integer('value');
        });
    }
}
