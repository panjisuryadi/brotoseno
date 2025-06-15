<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAssetsRepotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets_report', function (Blueprint $table) {
            $table->id();
            $table->integer('karat_id');
            $table->string('slug');
            $table->string('status_id')->nullable();
            $table->string('cabang_id')->nullable();
            $table->decimal('berat_real', 12, 3);
            $table->decimal('coef', 12, 3);
            $table->decimal('pure_gold', 12, 3);
            $table->integer('created_by');
            $table->date('date');
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
        Schema::dropIfExists('assets_report');
    }
}
