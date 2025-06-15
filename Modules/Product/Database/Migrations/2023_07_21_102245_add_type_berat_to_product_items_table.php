<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeBeratToProductItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_items', function (Blueprint $table) {
              $table->decimal('berat_total', 5, 2)->default(0.01)->after('gudang');
              $table->decimal('berat_emas', 5, 2)->default(0.01)->after('berat_total');
              $table->decimal('berat_accessories', 5, 2)->default(0.01)->after('berat_emas');
              $table->decimal('berat_label', 5, 2)->default(0.01)->after('berat_accessories');
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
         // $table->dropColumn('models_id');
         $table->dropColumn('berat_total');
         $table->dropColumn('berat_accessories');
         $table->dropColumn('berat_label');
         $table->dropColumn('berat_emas');
        });
    }
}
