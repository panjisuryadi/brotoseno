<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarangluarStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangluar_statuses', function (Blueprint $table) {
            $table->foreignId('barangluar_id')->constrained('penerimaanbarangluars')->cascadeOnDelete();
            $table->foreignId('status_id')->constrained('proses_statuses')->cascadeOnDelete();
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
        Schema::dropIfExists('barangluar_statuses');
    }
}
