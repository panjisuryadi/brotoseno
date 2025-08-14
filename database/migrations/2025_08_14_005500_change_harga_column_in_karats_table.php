<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeHargaColumnInKaratsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('karats', function (Blueprint $table) {
            // Change to decimal with large range
            $table->decimal('harga', 15, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('karats', function (Blueprint $table) {
            // Rollback to original size
            $table->decimal('harga', 5, 3)->change();
        });
    }
}
