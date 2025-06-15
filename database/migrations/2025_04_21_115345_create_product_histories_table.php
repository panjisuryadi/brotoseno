<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_histories', function (Blueprint $table) {
            $table->id(); // auto-increment primary key
            $table->integer('product_id'); // product_id column
            $table->char('status', 1); // status column with length 1
            $table->string('keterangan')->nullable();
            $table->integer('harga')->nullable(); // harga column (nullable)
            $table->date('tanggal'); // tanggal column
            $table->timestamps(); // created_at and updated_at columns with current timestamp by default
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_histories');
    }

}
