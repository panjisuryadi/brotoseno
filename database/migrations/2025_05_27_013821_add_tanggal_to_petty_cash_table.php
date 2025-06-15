<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTanggalToPettyCashTable extends Migration
{
    public function up()
    {
        Schema::table('petty_cash', function (Blueprint $table) {
            $table->date('tanggal')->after('id'); // menambahkan kolom tanggal setelah kolom id
        });
    }

    public function down()
    {
        Schema::table('petty_cash', function (Blueprint $table) {
            $table->dropColumn('tanggal');
        });
    }
}
