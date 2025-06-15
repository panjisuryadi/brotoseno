<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesGoldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_gold', function (Blueprint $table) {
            $table->id();  // This creates the `id` column as auto-increment primary key
            $table->integer('nomor');  // Integer for `nomor`
            $table->integer('customer')->nullable();  // Nullable integer for `customer`
            $table->text('products');  // Text column for `products`
            $table->text('services');  // Text column for `products`
            $table->integer('total');  // Integer for `total`
            $table->timestamps();  // This will create `created_at` and `updated_at` columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_gold');
    }
}
