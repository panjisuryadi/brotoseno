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
        Schema::create('penerimaanbarangluars', function (Blueprint $table) {
            $table->id();
            $table->string('no_barang_luar');
            $table->date('date');
            $table->string('customer_name');
            $table->string('product_name');
            $table->unsignedBigInteger('karat_id');
            $table->decimal('weight', 12, 3, true)->default(0);
            $table->unsignedBigInteger('nominal');
            $table->text('note')->nullable();
            $table->foreign('karat_id')->references('id')->on('karats');
            $table->timestamps();

        });
        // Create Permissions
        Permissions::firstOrCreate(['name' => 'access_penerimaanbarangluars']);
        Permissions::firstOrCreate(['name' => 'create_penerimaanbarangluars']);
        Permissions::firstOrCreate(['name' => 'edit_penerimaanbarangluars']);
        Permissions::firstOrCreate(['name' => 'delete_penerimaanbarangluars']);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penerimaanbarangluars');
    }
};
