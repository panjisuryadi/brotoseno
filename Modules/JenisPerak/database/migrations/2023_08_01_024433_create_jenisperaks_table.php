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
        Schema::create('jenisperaks', function (Blueprint $table) {
            $table->id();
            //$table->unsignedBigInteger('jenis_group_id');
            $table->string('name');
            $table->string('code')->nullable();
            $table->text('image')->nullable();
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
        Schema::dropIfExists('jenisperaks');
    }
};
