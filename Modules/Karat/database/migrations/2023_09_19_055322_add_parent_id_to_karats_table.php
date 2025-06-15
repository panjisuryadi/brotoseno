<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParentIdToKaratsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('karats', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')->after('id')->nullable();
            $table->foreign('parent_id')->references('id')->on('karats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('karats', function (Blueprint $table) {
            $table->dropConstrainedForeignId('parent_id');
        });
    }
}
