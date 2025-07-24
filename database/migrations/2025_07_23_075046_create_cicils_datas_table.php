<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCicilsDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cicils_datas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cicil_id');
            $table->unsignedBigInteger('sales_gold_id');
            $table->integer('nominal');
            $table->string('method', 20);
            $table->integer('bank')->default(0);
            $table->integer('rekening')->default(0);
            $table->timestamps();

            $table->foreign('sales_gold_id')->references('id')->on('sales_gold')->onDelete('cascade');
            $table->foreign('cicil_id')->references('id')->on('cicils')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cicils_datas');
    }
}
