<?php

namespace Modules\DistribusiSale\database\seeders;
//use Modules\DistribusiSale\database\seeders\DistribusiSaleDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\DistribusiSale\Models\DistribusiSale;
use Carbon\Carbon;
class DistribusiSaleDatabaseSeeder extends Seeder
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
         * DistribusiSales Seed
         * ------------------
         */

        // DB::table('distribusisales')->truncate();
        // echo "Truncate: distribusisales \n";

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
        //         $data = DistribusiSale::create($row);

        //     }


        DistribusiSale::factory()->count(20)->create();
        $rows = DistribusiSale::all();
        echo " Insert: distribusisales \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
