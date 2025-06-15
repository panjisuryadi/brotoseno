<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateColumnsToAdjustmentLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `adjustment_location` MODIFY `weight_before` DOUBLE(12,3) UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE `adjustment_location` MODIFY `weight_after` DOUBLE(12,3) UNSIGNED NOT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `adjustment_location` MODIFY `weight_before` DECIMAL(12,3) UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE `adjustment_location` MODIFY `weight_after` DECIMAL(12,3) UNSIGNED NOT NULL');
    }
}
