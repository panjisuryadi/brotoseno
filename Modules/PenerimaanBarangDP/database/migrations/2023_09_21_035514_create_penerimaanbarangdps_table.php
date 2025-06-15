<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Permissions;

class CreatePenerimaanbarangdpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penerimaanbarangdps', function (Blueprint $table) {
            $table->id();
            $table->string('no_barang_dp');
            $table->date('date');
            $table->string('owner_name');
            $table->string('contact_number');
            $table->text('address');
            $table->unsignedBigInteger('karat_id');
            $table->decimal('weight', 12, 3, true)->default(0);
            $table->unsignedBigInteger('nominal');
            $table->text('note')->nullable();
            $table->foreign('karat_id')->references('id')->on('karats');
            $table->timestamps();

        });
        // Create Permissions
        Permissions::firstOrCreate(['name' => 'access_penerimaanbarangdps']);
        Permissions::firstOrCreate(['name' => 'create_penerimaanbarangdps']);
        Permissions::firstOrCreate(['name' => 'edit_penerimaanbarangdps']);
        Permissions::firstOrCreate(['name' => 'delete_penerimaanbarangdps']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penerimaanbarangdps');
    }
};
