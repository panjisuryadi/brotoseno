<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategori_produk_id');
            $table->string('category_code')->unique();
            $table->string('category_name');
            $table->string('image')->nullable(true);
            $table->unsignedInteger('parent_id')->nullable();
            $table->foreign('kategori_produk_id')->references('id')->on('kategoriproduks')->restrictOnDelete();
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
        Schema::dropIfExists('categories');
    }
}
