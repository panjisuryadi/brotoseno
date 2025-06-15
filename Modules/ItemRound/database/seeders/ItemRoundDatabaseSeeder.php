<?php

namespace Modules\ItemRound\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\ItemRound\Models\ItemRound;
use Carbon\Carbon;
class ItemRoundDatabaseSeeder extends Seeder
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
         * ItemRounds Seed
         * ------------------
         */

        // DB::table('itemrounds')->truncate();
        // echo "Truncate: itemrounds \n";

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
        //         $data = ItemRound::create($row);

        //     }


        ItemRound::factory()->count(20)->create();
        $rows = ItemRound::all();
        echo " Insert: itemrounds \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
