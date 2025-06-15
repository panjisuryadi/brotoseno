<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteSomeColumnsInBuysbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buysbacks', function (Blueprint $table) {
            $table->dropColumn([
                'reference',
                'kode_sales',
                'supplier_name',
                'tax_percentage',
                'tax_amount',
                'discount_percentage',
                'discount_amount',
                'shipping_amount',
                'total_amount',
                'paid_amount',
                'due_amount',
                'status',
                'payment_status',
                'payment_method',
            ]);
            $table->dropConstrainedForeignId('supplier_id');
            $table->dropConstrainedForeignId('jenis_buyback_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buysbacks', function (Blueprint $table) {

        });
    }
}
