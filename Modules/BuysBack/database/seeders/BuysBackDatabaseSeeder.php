<?php

namespace Modules\BuysBack\database\seeders;
//use Modules\BuysBack\database\seeders\BuysBackDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\BuysBack\Models\BuysBack;
use Carbon\Carbon;
class BuysBackDatabaseSeeder extends Seeder
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
         * BuysBacks Seed
         * ------------------
         */

        // DB::table('buysbacks')->truncate();
        // echo "Truncate: buysbacks \n";

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
        //         $data = BuysBack::create($row);

        //     }


        BuysBack::factory()->count(20)->create();
        $rows = BuysBack::all();
        echo " Insert: buysbacks \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
