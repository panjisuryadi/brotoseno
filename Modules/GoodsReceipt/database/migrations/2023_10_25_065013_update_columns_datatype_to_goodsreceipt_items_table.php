<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateColumnsDatatypeToGoodsreceiptItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `goodsreceipt_items` MODIFY `berat_real` DOUBLE(12,3) UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE `goodsreceipt_items` MODIFY `berat_kotor` DOUBLE(12,3) UNSIGNED NOT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `goodsreceipt_items` MODIFY `berat_real` DECIMAL(12,3) UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE `goodsreceipt_items` MODIFY `berat_kotor` DECIMAL(12,3) UNSIGNED NOT NULL');
    }
}
