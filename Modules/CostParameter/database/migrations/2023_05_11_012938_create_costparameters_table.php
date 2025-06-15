<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costparameters', function (Blueprint $table) {
            $table->id();
            $table->string('kode_prefix');
            $table->integer('nominal')->nullable();
            $table->integer('persentase')->nullable();
            $table->string('type_ongkos')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('costparameters');
    }
};
