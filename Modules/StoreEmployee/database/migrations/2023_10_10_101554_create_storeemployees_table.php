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
        Schema::create('storeemployees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('cabang_id');
            $table->foreign('cabang_id')->references('id')->on('cabangs');
            $table->timestamps();

        });
        // Create Permissions
        Permissions::firstOrCreate(['name' => 'access_storeemployees']);
        Permissions::firstOrCreate(['name' => 'create_storeemployees']);
        Permissions::firstOrCreate(['name' => 'edit_storeemployees']);
        Permissions::firstOrCreate(['name' => 'delete_storeemployees']);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storeemployees');
    }
};
