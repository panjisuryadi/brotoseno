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
        Schema::create('history_distribusi_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_id');
            $table->date('date')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
            $table->foreign('sales_id')->references('id')->on('datasales');

        });
        // Create Permissions
        Permissions::firstOrCreate(['name' => 'access_distribusisales']);
        Permissions::firstOrCreate(['name' => 'create_distribusisales']);
        Permissions::firstOrCreate(['name' => 'edit_distribusisales']);
        Permissions::firstOrCreate(['name' => 'delete_distribusisales']);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distribusisales');
    }
};
