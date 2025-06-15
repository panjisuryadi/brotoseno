<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPicToPenerimaanbarangluarsalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penerimaanbarangluarsales', function (Blueprint $table) {
            $table->foreignId('pic_id')->nullable()->constrained('users');
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
            $table->dropConstrainedForeignId('pic_id');
        });
    }
}
