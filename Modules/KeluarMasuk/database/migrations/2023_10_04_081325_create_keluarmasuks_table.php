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
        Schema::create('keluarmasuks', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('karat_id');
            $table->text('description');
            $table->decimal('weight_in', 12, 3, true)->nullable();
            $table->decimal('weight_out', 12, 3, true)->nullable();
            $table->decimal('remaining_weight', 12, 3, true);

            $table->foreign('karat_id')->references('id')->on('karats');
            $table->timestamps();

        });
        // Create Permissions
        Permissions::firstOrCreate(['name' => 'access_keluarmasuks']);
        Permissions::firstOrCreate(['name' => 'create_keluarmasuks']);
        Permissions::firstOrCreate(['name' => 'edit_keluarmasuks']);
        Permissions::firstOrCreate(['name' => 'delete_keluarmasuks']);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keluarmasuks');
    }
};
