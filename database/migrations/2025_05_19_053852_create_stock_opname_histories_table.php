<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockOpnameHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_opname_histories', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->unsignedBigInteger('stock_opname_id');
            $table->unsignedBigInteger('baki_id');
            $table->unsignedBigInteger('product_id');
            $table->char('status', 1); // CHAR(1) - no default specified, so it will be required
            $table->string('keterangan', 255)->nullable(); // VARCHAR(255), can be null
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
        Schema::dropIfExists('stock_opname_histories');
    }
}
