<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Permissions;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_distribusi_toko', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cabang_id');
            $table->unsignedBigInteger('karat_id');
            $table->date('date')->nullable();
            $table->decimal('weight', 12, 3)->default(0.001);
            $table->string('created_by')->nullable();
            $table->timestamps();
            $table->foreign('cabang_id')->references('id')->on('cabangs');
            $table->foreign('karat_id')->references('id')->on('karats');

        });
        // Create Permissions
        Permissions::firstOrCreate(['name' => 'access_distribusitoko']);
        Permissions::firstOrCreate(['name' => 'create_distribusitoko']);
        Permissions::firstOrCreate(['name' => 'edit_distribusitoko']);
        Permissions::firstOrCreate(['name' => 'delete_distribusitoko']);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distribusitokos');
    }
};
