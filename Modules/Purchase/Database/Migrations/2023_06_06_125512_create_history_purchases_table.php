<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('qty')->default(0)->nullable();
            $table->string('username')->nullable();
            $table->integer('status')->default(0)->nullable();
            $table->foreign('purchase_id')->references('id')
                ->on('purchases')->cascadeOnDelete();
            $table->foreign('product_id')->references('id')
             ->on('products')->nullOnDelete();
            $table->foreign('user_id')->references('id')
            ->on('users')->nullOnDelete();
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
        Schema::dropIfExists('history_purchases');
    }
}
