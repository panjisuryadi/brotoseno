<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->id(); // Automatically creates an auto-incrementing primary key
            $table->string('name', 255); // For the 'name' column
            $table->text('value'); // For the 'value' column
            $table->char('status', 1)->default('A'); // For the 'status' column with default value 'A'
            $table->timestamps(); // Automatically creates 'created_at' and 'updated_at'
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configs');
    }
}
