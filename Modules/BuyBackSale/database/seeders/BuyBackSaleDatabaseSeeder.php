<?php

namespace Modules\BuyBackSale\database\seeders;
//use Modules\BuyBackSale\database\seeders\BuyBackSaleDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\BuyBackSale\Models\BuyBackSale;
use Carbon\Carbon;
class BuyBackSaleDatabaseSeeder extends Seeder
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
         * BuyBackSales Seed
         * ------------------
         */

        // DB::table('buybacksales')->truncate();
        // echo "Truncate: buybacksales \n";

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
        //         $data = BuyBackSale::create($row);

        //     }


        BuyBackSale::factory()->count(20)->create();
        $rows = BuyBackSale::all();
        echo " Insert: buybacksales \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
