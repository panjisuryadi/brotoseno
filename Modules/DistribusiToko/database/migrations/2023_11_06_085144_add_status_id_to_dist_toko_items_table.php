<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusIdToDistTokoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dist_toko_items', function (Blueprint $table) {
            $table->foreignId('status_id')->nullable()->constrained('distribusi_toko_item_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dist_toko_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('status_id');
        });
    }
}
