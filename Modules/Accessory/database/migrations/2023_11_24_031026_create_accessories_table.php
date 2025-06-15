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
        Schema::create('accessories', function (Blueprint $table) {
            $table->id();
            //$table->unsignedBigInteger('jenis_group_id');
            $table->string('name');
            $table->string('code');
            $table->text('description')->nullable();
            //$table->string('image')->nullable(true);
            // $table->foreign('jenis_group_id')->references('id')->on('jenisgroups')->restrictOnDelete();
            $table->timestamps();

        });
        // Create Permissions
        Permissions::firstOrCreate(['name' => 'access_accessories']);
        Permissions::firstOrCreate(['name' => 'create_accessories']);
        Permissions::firstOrCreate(['name' => 'edit_accessories']);
        Permissions::firstOrCreate(['name' => 'delete_accessories']);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accessories');
    }
};
