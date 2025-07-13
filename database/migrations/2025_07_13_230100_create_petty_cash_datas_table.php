<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePettyCashDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petty_cash_datas', function (Blueprint $table) {
            $table->id(); // id INT PRIMARY KEY AUTO_INCREMENT

            $table->unsignedBigInteger('petty_cash_id'); // petty_cash_id INT

            $table->integer('cash_in');   // cash_in INT
            $table->integer('cash_out');  // cash_out INT

            $table->text('keterangan');   // keterangan TEXT

            $table->timestamps();         // created_at & updated_at

            // If you want to link to petty_cash table:
            $table->foreign('petty_cash_id')
                  ->references('id')
                  ->on('petty_cashs')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('petty_cash_datas');
    }
}
