<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToProductItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_items', function (Blueprint $table) {
            $table->integer('diamond_certificate_id')->nullable();
            $table->string('gia_report_number')->nullable();
            $table->decimal('karatberlians')->nullable();
            $table->integer('shapeberlians_id')->nullable();
            $table->integer('qty')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_items', function (Blueprint $table) {
            $table->dropColumn('diamond_certificate_id');
            $table->dropColumn('gia_report_number');
            $table->dropColumn('karatberlians');
            $table->dropColumn('shapeberlians_id');
            $table->dropColumn('qty');
        });
    }
}
