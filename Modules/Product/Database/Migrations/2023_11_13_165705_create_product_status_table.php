<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Product\Models\ProductStatus;

class CreateProductStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_status', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        ProductStatus::create(['id'=>1, 'name'=> 'ready']);
        ProductStatus::create(['id'=>2, 'name'=> 'sold']);
        ProductStatus::create(['id'=>3, 'name'=> 'pending']);
        ProductStatus::create(['id'=>4, 'name'=> 'pending office']);
        ProductStatus::create(['id'=>5, 'name'=> 'cuci']);
        ProductStatus::create(['id'=>6, 'name'=> 'masak']);
        ProductStatus::create(['id'=>7, 'name'=> 'rongsok']);
        ProductStatus::create(['id'=>8, 'name'=> 'reparasi']);
        ProductStatus::create(['id'=>9, 'name'=> 'second']);
        ProductStatus::create(['id'=>10, 'name'=> 'hilang']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_status');
    }
}
