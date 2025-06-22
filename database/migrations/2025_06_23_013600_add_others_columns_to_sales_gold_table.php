<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOthersColumnsToSalesGoldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_gold', function (Blueprint $table) {
            $table->integer('qr')->default(0)->after('transfer');
            $table->integer('cc')->default(0)->after('qr');
            $table->integer('cc_up')->default(0)->after('cc');
            $table->unsignedBigInteger('bank_id')->nullable()->after('cc_up');
            $table->unsignedBigInteger('rekening_id')->nullable()->after('bank_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_gold', function (Blueprint $table) {
            $table->dropColumn(['qr', 'cc', 'cc_up', 'bank_id', 'rekening_id']);
        });
    }
}
