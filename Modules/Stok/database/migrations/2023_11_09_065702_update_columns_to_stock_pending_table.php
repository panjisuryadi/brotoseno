<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateColumnsToStockPendingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_pending', function (Blueprint $table) {
            $table->dropConstrainedForeignId('sales_id');
            $table->dropColumn('type');
        });
        DB::statement('ALTER TABLE `stock_pending` MODIFY `weight` DOUBLE(12,3) UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE `stock_pending` MODIFY `cabang_id` BIGINT UNSIGNED NOT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_pending', function (Blueprint $table) {
            $table->foreignId('sales_id')->nullable()->constrained('datasales');
            $table->enum('type',['buyback','barangluar']);
        });
        DB::statement('ALTER TABLE `stock_pending` MODIFY `weight` DECIMAL(12,3) UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE `stock_pending` MODIFY `cabang_id` BIGINT UNSIGNED NULL');
    }
}
