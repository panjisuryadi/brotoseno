<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusIdToHistoryDistribusiTokoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_distribusi_toko', function (Blueprint $table) {
            $table->foreignId('status_id')->nullable()->constrained('distribusi_toko_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('history_distribusi_toko', function (Blueprint $table) {
            $table->dropConstrainedForeignId('status_id');
        });
    }
}
