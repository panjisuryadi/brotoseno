<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHargaSilversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harga_silvers', function (Blueprint $table) {
            $table->id(); 

            // harga bigint
            $table->bigInteger('harga');

            // tanggal datetime
            $table->dateTime('tanggal');
            
            // user int (Foreign Key)
            // Menggunakan foreignId() adalah cara modern Laravel untuk membuat kolom kunci asing
            $table->foreignId('user_id')
                  ->constrained('users') // Mengasumsikan tabel user Anda bernama 'users'
                  ->onDelete('cascade'); // Opsi: Hapus harga jika user terhapus

            // timestamp() - ini akan membuat created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('harga_silvers');
    }
}
