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
        Schema::create('penjualan_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_id');
            $table->date('date')->nullable();
            $table->string('store_name')->nullable();
            $table->string('invoice_no')->nullable();
            $table->decimal('total_weight', 12, 3)->default(0.001);
            $table->decimal('total_nominal', 12, 2)->default(0.01);
            $table->string('created_by')->nullable();
            $table->timestamps();
            $table->foreign('sales_id')->references('id')->on('datasales');
   

        });
        // Create Permissions
        Permissions::firstOrCreate(['name' => 'access_penjualansales']);
        Permissions::firstOrCreate(['name' => 'create_penjualansales']);
        Permissions::firstOrCreate(['name' => 'edit_penjualansales']);
        Permissions::firstOrCreate(['name' => 'delete_penjualansales']);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualansales');
    }
};
