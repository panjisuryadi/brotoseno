<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKaratIdToGoodsreceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goodsreceipts', function (Blueprint $table) {
              $table->unsignedBigInteger('karat_id')->nullable()->after('total_emas');
               $table->decimal('selisih', 12, 3)->nullable()
               ->change();
               $table->foreign('karat_id')->references('id')
               ->on('karats')->nullOnDelete();

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

        });
    }
}
