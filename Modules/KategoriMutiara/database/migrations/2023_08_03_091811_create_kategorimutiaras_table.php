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
        Schema::create('kategorimutiaras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jenis_mutiara_id');
            $table->string('name');
            $table->foreign('jenis_mutiara_id')->references('id')
            ->on('jenismutiaras');
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
        Schema::dropIfExists('kategorimutiaras');
    }
};
