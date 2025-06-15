<?php

namespace Modules\ItemClarity\database\seeders;
//use Modules\ItemClarity\database\seeders\ItemClarityDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\ItemClarity\Models\ItemClarity;
use Carbon\Carbon;
class ItemClarityDatabaseSeeder extends Seeder
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
         * ItemClarities Seed
         * ------------------
         */

        // DB::table('itemclarities')->truncate();
        // echo "Truncate: itemclarities \n";

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
        //         $data = ItemClarity::create($row);

        //     }


        ItemClarity::factory()->count(20)->create();
        $rows = ItemClarity::all();
        echo " Insert: itemclarities \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
