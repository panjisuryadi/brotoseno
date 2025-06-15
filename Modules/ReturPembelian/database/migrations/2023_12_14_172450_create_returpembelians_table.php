<?php

use App\Models\Permissions;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturpembeliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returpembelians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->string('retur_no');
            $table->decimal('total_weight', 12,3, true);
            $table->string('created_by');
            $table->timestamps();

        });
        // Create Permissions
        Permissions::firstOrCreate(['name' => 'access_retur_pembelian']);
        Permissions::firstOrCreate(['name' => 'create_retur_pembelian']);
        Permissions::firstOrCreate(['name' => 'edit_retur_pembelian']);
        Permissions::firstOrCreate(['name' => 'delete_retur_pembelian']);
        Permissions::firstOrCreate(['name' => 'print_retur_pembelian']);
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('returpembelians');
    }
}
