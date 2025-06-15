<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistribusiTokoTrackingStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distribusi_toko_tracking_statuses', function (Blueprint $table) {
            $table->foreignId('dist_toko_id')->constrained('history_distribusi_toko');
            $table->foreignId('status_id')->constrained('distribusi_toko_status');
            $table->foreignId('pic_id')->constrained('users');
            $table->text('note')->nullable();
            $table->dateTime('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distribusi_toko_tracking_statuses');
    }
}
