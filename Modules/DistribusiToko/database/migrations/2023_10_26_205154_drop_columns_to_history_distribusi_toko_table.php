<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class DropColumnsToHistoryDistribusiTokoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_distribusi_toko', function (Blueprint $table) {
            $table->dropConstrainedForeignId('karat_id');
        });

        DB::statement('ALTER TABLE `history_distribusi_toko` MODIFY `weight` DOUBLE(12,3) UNSIGNED NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('history_distribusi_toko', function (Blueprint $table) {
            $table->foreignId('karat_id')->constrained('karats');
        });

        DB::statement('ALTER TABLE `history_distribusi_toko` MODIFY `weight` DECIMAL(12,3) UNSIGNED NULL');
    }
}
