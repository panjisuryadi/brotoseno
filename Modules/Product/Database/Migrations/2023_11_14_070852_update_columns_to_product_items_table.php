<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateColumnsToProductItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `product_items` MODIFY `berat_total` DOUBLE(12,3) UNSIGNED NULL DEFAULT 0');
        DB::statement('ALTER TABLE `product_items` MODIFY `berat_emas` DOUBLE(12,3) UNSIGNED NULL DEFAULT 0');
        DB::statement('ALTER TABLE `product_items` MODIFY `berat_accessories` DOUBLE(12,3) UNSIGNED NULL DEFAULT 0');
        DB::statement('ALTER TABLE `product_items` MODIFY `tag_label` DOUBLE(12,3) UNSIGNED NULL DEFAULT 0');
        DB::statement('ALTER TABLE `product_items` MODIFY `berat_label` DOUBLE(12,3) UNSIGNED NULL DEFAULT 0');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `product_items` MODIFY `berat_total` DECIMAL(12,3) UNSIGNED NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE `product_items` MODIFY `berat_emas` DECIMAL(12,3) UNSIGNED NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE `product_items` MODIFY `berat_accessories` DECIMAL(12,3) UNSIGNED NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE `product_items` MODIFY `tag_label` DECIMAL(12,3) UNSIGNED NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE `product_items` MODIFY `berat_label` DECIMAL(12,3) UNSIGNED NOT NULL DEFAULT 0');
    }
}
