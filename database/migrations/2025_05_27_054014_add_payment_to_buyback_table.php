<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentToBuybackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buyback', function (Blueprint $table) {
            $table->string('payment', 20)->after('status'); // menambahkan kolom tanggal setelah kolom id
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buyback', function (Blueprint $table) {
            $table->dropColumn('payment');
        });
    }
}
