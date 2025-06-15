<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductHistoryPenyusutanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_history_penyusutan', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('product_id');
            $table->decimal('berat_asal', 12,3,true)->default(0);
            $table->decimal('berat_asli', 12,3,true)->default(0);
            $table->decimal('berat_susut', 12,3,true)->default(0);
            $table->tinyInteger('created_by')->nullable();
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
        Schema::dropIfExists('product_history_penyusutan');
    }
}
