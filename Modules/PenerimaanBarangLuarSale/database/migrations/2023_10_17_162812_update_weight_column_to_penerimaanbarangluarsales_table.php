<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateWeightColumnToPenerimaanbarangluarsalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `penerimaanbarangluarsales` MODIFY `weight` DOUBLE(12,3) UNSIGNED NOT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `penerimaanbarangluarsales` MODIFY `weight` DECIMAL(12,3) UNSIGNED NOT NULL');
    }
}
