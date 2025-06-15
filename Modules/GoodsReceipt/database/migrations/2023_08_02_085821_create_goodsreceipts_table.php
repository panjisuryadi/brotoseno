<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
  // drop the table
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('goodsreceipts');
        Schema::create('goodsreceipts', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('code');
            $table->string('no_invoice');
            $table->decimal('berat_kotor', 12, 3)->default(0.001);
            $table->decimal('berat_real', 12, 3)->default(0.001);
            $table->decimal('selisih', 12, 3)->default(0.001);
            $table->string('pengirim')->nullable();
            $table->text('note')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('kategoriproduk_id')->nullable();
            $table->unsignedBigInteger('parameterkadar_id')->nullable();
            $table->string('tipe_pembayaran')->nullable();
            $table->string('count')->default(0);
            $table->string('qty')->default(0);
            $table->timestamps();
           
            $table->foreign('kategoriproduk_id')->references('id')->on('kategoriproduks')->nullOnDelete();

             $table->foreign('parameterkadar_id')->references('id')->on('parameterkadars')->nullOnDelete();

            $table->foreign('user_id')->references('id')
            ->on('users')->nullOnDelete();

            $table->foreign('supplier_id')->references('id')
            ->on('suppliers')->nullOnDelete();
            
             DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goodsreceipts');
    }
};
