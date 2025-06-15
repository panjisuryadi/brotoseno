<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePettyCashTable extends Migration
{
    public function up()
    {
        Schema::create('petty_cash', function (Blueprint $table) {
            $table->id(); // id int auto increment primary key
            $table->integer('modal')->default(0);
            $table->integer('current')->default(0);
            $table->integer('in')->default(0);
            $table->integer('out')->default(0);
            $table->string('keterangan', 255)->nullable();
            $table->char('status', 1)->default('A');
            $table->timestamps(); // created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('petty_cash');
    }
}
