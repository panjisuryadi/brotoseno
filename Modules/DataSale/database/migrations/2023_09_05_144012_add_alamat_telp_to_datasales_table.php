<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class AddAlamatTelpToDatasalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::table('datasales', function (Blueprint $table) {
        $table->dropColumn('code');
        $table->string('address')->nullable()->after('name');
        $table->string('phone')->nullable()->after('address');

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
        Schema::table('datasales', function (Blueprint $table) {
              $table->dropColumn('address');
              $table->dropColumn('phone');

        });
    }
}
