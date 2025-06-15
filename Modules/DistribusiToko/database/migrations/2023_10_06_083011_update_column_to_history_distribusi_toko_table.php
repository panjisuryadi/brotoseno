<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnToHistoryDistribusiTokoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_distribusi_toko', function (Blueprint $table) {
            $table->decimal('weight', 12, 3)->default(0.000)->nullable()->change();
            $table->string('no_invoice');
            $table->unsignedBigInteger('kategori_produk_id');
            
            $table->foreign('kategori_produk_id')->references('id')->on('kategoriproduks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('history_distribusi_toko', function (Blueprint $table) {
            $table->decimal('weight', 12, 3)->default(0.000)->nullable(false)->change();
            $table->dropColumn('no_invoice');
            $table->dropConstrainedForeignId('kategori_produk_id');
        });
    }
}
