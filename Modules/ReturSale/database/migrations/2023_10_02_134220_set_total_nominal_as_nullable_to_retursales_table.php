<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetTotalNominalAsNullableToRetursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('retursales', function (Blueprint $table) {
            $table->decimal('total_nominal', 12, 2)->default(0)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('retursales', function (Blueprint $table) {
            $table->decimal('total_nominal', 12, 2)->default(0)->nullable(false)->change();
        });
    }
}
