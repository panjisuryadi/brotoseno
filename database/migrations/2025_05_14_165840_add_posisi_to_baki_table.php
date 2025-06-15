<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPosisiToBakiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('baki', function (Blueprint $table) {
            $table->string('posisi', 10)->nullable(); // You can remove `nullable()` if you want it to be required
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('baki', function (Blueprint $table) {
            $table->dropColumn('posisi');
        });
    }
}
