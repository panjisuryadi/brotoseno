<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterHargasTableChangeHargaColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hargas', function (Blueprint $table) {
            // Modify 'harga' column to DECIMAL(10, 2) to support larger values
            $table->decimal('harga', 10, 2)->change();
        });
    }

    public function down()
    {
        Schema::table('hargas', function (Blueprint $table) {
            // Optionally, revert back to the original DECIMAL(8, 2) type
            $table->decimal('harga', 8, 2)->change();
        });
    }

}
