<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnsToBuybackNotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buyback_nota', function (Blueprint $table) {
            $table->renameColumn('no_invoice','invoice');
            $table->unsignedInteger('invoice_number')->nullable();
            $table->string('invoice_series')->nullable();
            $table->unique(['invoice_series','invoice_number']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buyback_nota', function (Blueprint $table) {
            $table->renameColumn('invoice','no_invoice');
            $table->dropUnique(['invoice_series','invoice_number']);
            $table->dropColumn(['invoice_number','invoice_series']);
        });
    }
}
