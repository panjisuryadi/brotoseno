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
        Schema::create('timbangans', function (Blueprint $table) {
            $table->id();
            //$table->unsignedBigInteger('jenis_group_id');
            $table->decimal('old_weight', 5, 2)->default(0.01);
            $table->decimal('new_weight', 5, 2)->default(0.01);
            $table->text('note')->nullable();
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
        Schema::dropIfExists('timbangans');
    }
};
