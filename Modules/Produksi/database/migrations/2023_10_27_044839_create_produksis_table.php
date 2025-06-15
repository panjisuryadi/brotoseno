<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Permissions;

class CreateProduksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produksis', function (Blueprint $table) {
            $table->id();
            $table->string('source_kode')->nullable();
            $table->date('tanggal')->nullable();
            $table->integer('karatasal_id')->nullable();
            $table->float('berat_asal')->nullable();
            $table->integer('karat_id')->nullable();
            $table->integer('kategoriproduk_id')->nullable();
            $table->float('berat')->nullable();
            $table->integer('model_id')->nullable(); //if null / 0 means other
            $table->text('description')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();

        });
        // Create Permissions
        Permissions::firstOrCreate(['name' => 'access_produksis']);
        Permissions::firstOrCreate(['name' => 'create_produksis']);
        Permissions::firstOrCreate(['name' => 'edit_produksis']);
        Permissions::firstOrCreate(['name' => 'delete_produksis']);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produksis');
    }
};
