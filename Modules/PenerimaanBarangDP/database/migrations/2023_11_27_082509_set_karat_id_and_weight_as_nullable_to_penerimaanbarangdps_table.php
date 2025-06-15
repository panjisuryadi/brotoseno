<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class SetKaratIdAndWeightAsNullableToPenerimaanbarangdpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement('ALTER TABLE `penerimaanbarangdps` MODIFY `karat_id` BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE `penerimaanbarangdps` MODIFY `weight` DECIMAL(12,3) UNSIGNED NULL');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement('ALTER TABLE `penerimaanbarangdps` MODIFY `karat_id` BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE `penerimaanbarangdps` MODIFY `weight` DECIMAL(12,3) UNSIGNED NOT NULL');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
