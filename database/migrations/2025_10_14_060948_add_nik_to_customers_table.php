<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNikToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Add the 'nik' column as a string (VARCHAR) with length 50.
            // It is NOT NULL and defaults to '0'.
            // The column is placed AFTER the 'address' column.
            $table->string('nik', 50)
                  ->nullable(false) // Ensures it's NOT NULL
                  ->default('0')
                  ->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Drop the column if the migration is rolled back
            $table->dropColumn('nik');
        });
    }
}
