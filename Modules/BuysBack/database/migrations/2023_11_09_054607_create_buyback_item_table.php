<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuybackItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyback_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('cabang_id')->constrained('cabangs');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('status_id')->nullable()->constrained('proses_statuses');
            $table->foreignId('buyback_nota_id')->nullable()->constrained('buyback_nota');
            $table->foreignId('karat_id')->constrained('karats');
            $table->foreignId('pic_id')->constrained('users');
            $table->unsignedInteger('nominal');
            $table->text('note')->nullable();
            $table->double('weight',12,3,true);
            $table->date('date');
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
        Schema::dropIfExists('buyback_item');
    }
}
