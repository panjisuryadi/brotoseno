<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParameterBaruToJenisperhiasansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::table('jenisperhiasans', function (Blueprint $table) {
            $table->string('ct')->nullable()->after('name');
            $table->string('hallmark')->nullable()->after('ct');
            $table->string('kadar')->nullable()->after('hallmark');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jenisperhiasans', function (Blueprint $table) {
             $table->dropColumn('ct');
             $table->dropColumn('hallmark');
             $table->dropColumn('kadar');
        });
    }
}
