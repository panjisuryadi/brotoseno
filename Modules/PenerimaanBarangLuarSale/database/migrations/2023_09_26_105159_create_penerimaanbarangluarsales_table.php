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
        Schema::create('penerimaanbarangluarsales', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('no_barang_luar');
            $table->unsignedBigInteger('customer_sales_id');
            $table->unsignedBigInteger('sales_id');
            $table->string('product_name');
            $table->unsignedBigInteger('karat_id');
            $table->decimal('weight', 12, 3, true)->default(0);
            $table->unsignedBigInteger('nominal');
            $table->text('note')->nullable();
            $table->foreign('karat_id')->references('id')->on('karats');
            $table->foreign('customer_sales_id')->references('id')->on('customer_sales');
            $table->foreign('sales_id')->references('id')->on('datasales');
            $table->timestamps();

        });
        // Create Permissions
        Permissions::firstOrCreate(['name' => 'access_penerimaanbarangluarsales']);
        Permissions::firstOrCreate(['name' => 'create_penerimaanbarangluarsales']);
        Permissions::firstOrCreate(['name' => 'edit_penerimaanbarangluarsales']);
        Permissions::firstOrCreate(['name' => 'delete_penerimaanbarangluarsales']);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penerimaanbarangluarsales');
    }
};
