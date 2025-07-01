<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTambahanAndPotonganToBuybackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buyback', function (Blueprint $table) {
            $table->integer('tambahan')->default(0);
            $table->integer('potongan')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buyback', function (Blueprint $table) {
            $table->dropColumn(['tambahan', 'potongan']);
        });
    }
}
