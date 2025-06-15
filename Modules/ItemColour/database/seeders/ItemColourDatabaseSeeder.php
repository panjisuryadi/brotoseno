<?php

namespace Modules\ItemColour\database\seeders;
//use Modules\ItemColour\database\seeders\ItemColourDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\ItemColour\Models\ItemColour;
use Carbon\Carbon;
class ItemColourDatabaseSeeder extends Seeder
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
         * ItemColours Seed
         * ------------------
         */

        // DB::table('itemcolours')->truncate();
        // echo "Truncate: itemcolours \n";

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
        //         $data = ItemColour::create($row);

        //     }


        ItemColour::factory()->count(20)->create();
        $rows = ItemColour::all();
        echo " Insert: itemcolours \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
