<?php

namespace Modules\DataSale\database\seeders;
//use Modules\DataSale\database\seeders\DataSaleDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\DataSale\Models\DataSale;
use Carbon\Carbon;
class DataSaleDatabaseSeeder extends Seeder
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
         * DataSales Seed
         * ------------------
         */

        // DB::table('datasales')->truncate();
        // echo "Truncate: datasales \n";

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
        //         $data = DataSale::create($row);

        //     }


        DataSale::factory()->count(20)->create();
        $rows = DataSale::all();
        echo " Insert: datasales \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
