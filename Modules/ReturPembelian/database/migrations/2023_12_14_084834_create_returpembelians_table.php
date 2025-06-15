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
        // Schema::create('returpembelians', function (Blueprint $table) {
        //     $table->id();
        //     //$table->unsignedBigInteger('jenis_group_id');
        //     $table->string('name');
        //     $table->string('code');
        //     $table->text('description')->nullable();
        //     //$table->string('image')->nullable(true);
        //     // $table->foreign('jenis_group_id')->references('id')->on('jenisgroups')->restrictOnDelete();
        //     $table->timestamps();

        // });
        // // Create Permissions
        // Permissions::firstOrCreate(['name' => 'access_retur_pembelian']);
        // Permissions::firstOrCreate(['name' => 'create_retur_pembelian']);
        // Permissions::firstOrCreate(['name' => 'edit_retur_pembelian']);
        // Permissions::firstOrCreate(['name' => 'delete_retur_pembelian']);
        // Permissions::firstOrCreate(['name' => 'print_retur_pembelian']);
       


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('returpembelians');
    }
};
