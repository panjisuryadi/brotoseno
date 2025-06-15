<?php

namespace Modules\ItemShape\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\ItemShape\Models\ItemShape;
use Carbon\Carbon;
class ItemShapeDatabaseSeeder extends Seeder
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
         * ItemShapes Seed
         * ------------------
         */

        // DB::table('itemshapes')->truncate();
        // echo "Truncate: itemshapes \n";

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
        //         $data = ItemShape::create($row);

        //     }


        ItemShape::factory()->count(20)->create();
        $rows = ItemShape::all();
        echo " Insert: itemshapes \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
