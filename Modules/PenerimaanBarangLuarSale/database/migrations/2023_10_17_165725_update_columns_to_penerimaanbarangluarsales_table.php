<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnsToPenerimaanbarangluarsalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penerimaanbarangluarsales', function (Blueprint $table) {
            $table->dropColumn('nominal');
            $table->unsignedInteger('nilai_angkat');
            $table->unsignedInteger('nilai_tafsir');
            $table->integer('nilai_selisih');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penerimaanbarangluarsales', function (Blueprint $table) {
            $table->unsignedBigInteger('nominal');
            $table->dropColumn(['nilai_angkat','nilai_tafsir','nilai_selisih']);
        });
    }
}
