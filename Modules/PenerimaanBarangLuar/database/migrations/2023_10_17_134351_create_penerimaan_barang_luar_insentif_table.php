<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenerimaanBarangLuarInsentifTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penerimaan_barang_luar_insentif', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('cabang_id')->nullable()->constrained('cabangs');
            $table->foreignId('sales_id')->nullable()->constrained('datasales');
            $table->unsignedInteger('incentive');
            $table->unique(['date','cabang_id']);
            $table->unique(['date','sales_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penerimaan_barang_luar_insentif');
    }
}
