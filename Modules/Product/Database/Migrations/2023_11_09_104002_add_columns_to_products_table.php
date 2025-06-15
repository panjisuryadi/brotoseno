<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('diamond_certificate_id')->nullable();
            $table->foreignId('karat_id')->nullable()->constrained('karats');
            $table->double('berat_emas',12, 3, true)->nullable();
            $table->double('total_karatberlians',12, 3, true)->nullable();
            $table->unsignedInteger('product_price')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('diamond_certificate_id');
            $table->dropConstrainedForeignId('karat_id');
            $table->dropColumn('product_price');
            $table->dropColumn('berat_emas');
            $table->dropColumn('total_karatberlians');
        });
    }
}
