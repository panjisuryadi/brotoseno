<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalInformationColumnToDistribusiTokoTrackingStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distribusi_toko_tracking_statuses', function (Blueprint $table) {
            $table->json('additional_information')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('distribusi_toko_tracking_statuses', function (Blueprint $table) {
            $table->dropColumn('additional_information');
        });
    }
}
