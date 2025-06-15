<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusIdToPenerimaanbarangluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penerimaanbarangluars', function (Blueprint $table) {
            $table->foreignId('status_id')->nullable()->constrained('proses_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penerimaanbarangluars', function (Blueprint $table) {
            $table->dropConstrainedForeignId('status_id');
        });
    }
}
