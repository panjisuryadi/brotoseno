<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebcamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webcams', function (Blueprint $table) {
            $table->id(); // This creates an auto-incrementing ID column (equivalent to INT PRIMARY)
            $table->integer('value'); // This creates an 'int' column for value
            $table->string('status'); // This creates a 'status' column (adjust the type if needed, such as enum or text)
            $table->timestamps(); // This creates 'created_at' and 'updated_at' columns automatically
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webcams');
    }
}
