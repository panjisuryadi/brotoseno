<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToProduksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produksis', function (Blueprint $table) {
            $table->integer('status')->default(1)->comment('1 untuk available 2 jika sudah didistribusikan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produksis', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
