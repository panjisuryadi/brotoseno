<?php

use App\Models\Permissions;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_sales', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('city');
            $table->string('country');
            $table->text('address');
            $table->timestamps();
        });

        // Create Permissions
        Permissions::firstOrCreate(['name' => 'access_customersales']);
        Permissions::firstOrCreate(['name' => 'create_customersales']);
        Permissions::firstOrCreate(['name' => 'show_customersales']);
        Permissions::firstOrCreate(['name' => 'update_customersales']);
        Permissions::firstOrCreate(['name' => 'edit_customersales']);
        Permissions::firstOrCreate(['name' => 'delete_customersales']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_sales');
    }
}
