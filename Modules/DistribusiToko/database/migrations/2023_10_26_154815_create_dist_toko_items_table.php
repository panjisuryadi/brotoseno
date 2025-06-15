<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistTokoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dist_toko_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dist_toko_id')->constrained('history_distribusi_toko')->cascadeOnDelete();
            $table->foreignId('karat_id')->constrained('karats');
            $table->json('additional_data')->nullable();
            $table->double('accessories_weight',12,3)->nullable();
            $table->double('tag_weight',12,3)->nullable();
            $table->double('gold_weight',12,3);
            $table->double('total_weight',12,3);
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
        Schema::dropIfExists('dist_toko_items');
    }
}
