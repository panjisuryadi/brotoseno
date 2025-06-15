<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateColumnsDatatypeToGoodsreceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `goodsreceipts` MODIFY `total_emas` DOUBLE(12,3) UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE `goodsreceipts` MODIFY `total_berat_kotor` DOUBLE(12,3) UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE `goodsreceipts` MODIFY `berat_timbangan` DOUBLE(12,3) UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE `goodsreceipts` MODIFY `selisih` DOUBLE(12,3) NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `goodsreceipts` MODIFY `total_emas` DECIMAL(12,3) UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE `goodsreceipts` MODIFY `total_berat_kotor` DECIMAL(12,3) UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE `goodsreceipts` MODIFY `berat_timbangan` DECIMAL(12,3) UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE `goodsreceipts` MODIFY `selisih` DECIMAL(12,3) NULL');
    }
}
