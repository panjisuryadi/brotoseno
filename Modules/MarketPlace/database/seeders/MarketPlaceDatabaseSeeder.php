<?php

namespace Modules\MarketPlace\database\seeders;
//use Modules\MarketPlace\database\seeders\MarketPlaceDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\MarketPlace\Models\MarketPlace;
use Carbon\Carbon;
class MarketPlaceDatabaseSeeder extends Seeder
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
         * MarketPlaces Seed
         * ------------------
         */

        // DB::table('marketplaces')->truncate();
        // echo "Truncate: marketplaces \n";

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
        //         $data = MarketPlace::create($row);

        //     }


        MarketPlace::factory()->count(20)->create();
        $rows = MarketPlace::all();
        echo " Insert: marketplaces \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
