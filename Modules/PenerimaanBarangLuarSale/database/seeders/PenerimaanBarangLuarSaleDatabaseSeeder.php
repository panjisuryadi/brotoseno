<?php

namespace Modules\PenerimaanBarangLuarSale\database\seeders;
//use Modules\PenerimaanBarangLuarSale\database\seeders\PenerimaanBarangLuarSaleDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\PenerimaanBarangLuarSale\Models\PenerimaanBarangLuarSale;
use Carbon\Carbon;
class PenerimaanBarangLuarSaleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        /*
         * PenerimaanBarangLuarSales Seed
         * ------------------
         */

        // DB::table('penerimaanbarangluarsales')->truncate();
        // echo "Truncate: penerimaanbarangluarsales \n";

        //  $data = [
        //     [
        //         'id'                 => 1,
        //         'name'               => 'Inclusive',
        //         'description'        => 'Diamond - Inclusive',
        //         'created_at'         => Carbon::now(),
        //         'updated_at'         => Carbon::now(),
        //     ],

        // ];

        //     foreach ($data as $row) {
        //         $data = PenerimaanBarangLuarSale::create($row);

        //     }


        PenerimaanBarangLuarSale::factory()->count(20)->create();
        $rows = PenerimaanBarangLuarSale::all();
        echo " Insert: penerimaanbarangluarsales \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
