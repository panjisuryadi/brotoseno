<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAlamatTlpToCabangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cabangs', function (Blueprint $table) {
            $table->text('alamat')->nullable()->after('name');
            $table->string('tlp')->nullable()->after('alamat');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cabangs', function (Blueprint $table) {

        });
    }
}
