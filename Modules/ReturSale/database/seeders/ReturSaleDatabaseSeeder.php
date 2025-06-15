<?php

namespace Modules\ReturSale\database\seeders;
//use Modules\ReturSale\database\seeders\ReturSaleDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\ReturSale\Models\ReturSale;
use Carbon\Carbon;
class ReturSaleDatabaseSeeder extends Seeder
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
         * ReturSales Seed
         * ------------------
         */

        // DB::table('retursales')->truncate();
        // echo "Truncate: retursales \n";

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
        //         $data = ReturSale::create($row);

        //     }


        ReturSale::factory()->count(20)->create();
        $rows = ReturSale::all();
        echo " Insert: retursales \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
