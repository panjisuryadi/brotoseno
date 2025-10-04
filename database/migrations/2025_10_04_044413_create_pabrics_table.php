<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePabricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('pabrics', function (Blueprint $table) {
            // id int primary auto
            $table->id(); 

            // name string 255 uniq
            $table->string('name', 255)->unique();

            // status char 1 default 'A'
            $table->char('status', 1)->default('A');

            // timestamp() - ini akan membuat created_at dan updated_at
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
        Schema::dropIfExists('pabrics');
    }
}
