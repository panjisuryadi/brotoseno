<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateWeightColumnToPenerimaanbarangluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `penerimaanbarangluars` MODIFY `weight` DOUBLE(12,3) UNSIGNED NOT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `penerimaanbarangluars` MODIFY `weight` DECIMAL(12,3) UNSIGNED NOT NULL');
    }
}
