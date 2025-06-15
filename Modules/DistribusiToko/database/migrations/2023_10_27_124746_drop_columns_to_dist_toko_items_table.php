<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnsToDistTokoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("dist_toko_items", function (Blueprint $table) {
            $table->dropColumn([
                "accessories_weight",
                "tag_weight",
                "total_weight"
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("dist_toko_items", function (Blueprint $table) {
            $table->double('accessories_weight',12,3)->nullable();
            $table->double('tag_weight',12,3)->nullable();
            $table->double('total_weight',12,3);
        });
    }
}
