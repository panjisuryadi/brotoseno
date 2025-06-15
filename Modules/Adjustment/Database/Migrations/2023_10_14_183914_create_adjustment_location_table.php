<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdjustmentLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjustment_location', function (Blueprint $table) {
            $table->foreignId('adjustment_id')->constrained('adjustments');
            $table->morphs('location');
            $table->decimal('weight_before', 12, 3);
            $table->decimal('weight_after', 12, 3);
            $table->text('summary')->nullable();
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
        Schema::dropIfExists('adjustment_location');
    }
}
