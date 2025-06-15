<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalEmasToGoodsreceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       // Schema::dropColumn('total_emas');
        Schema::table('goodsreceipts', function (Blueprint $table) {
            $table->decimal('total_emas', 12, 3)->default(0.001)->after('qty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('goodsreceipts', function (Blueprint $table) {
            Schema::dropIfExists('total_emas');
        });
    }
}
