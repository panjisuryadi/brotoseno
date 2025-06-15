<?php

namespace Modules\GoldCategory\database\seeders;
//use Modules\GoldCategory\database\seeders\GoldCategoryDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\GoldCategory\Models\GoldCategory;
use Carbon\Carbon;
class GoldCategoryDatabaseSeeder extends Seeder
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
         * GoldCategories Seed
         * ------------------
         */

        // DB::table('goldcategories')->truncate();
        // echo "Truncate: goldcategories \n";

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
        //         $data = GoldCategory::create($row);

        //     }


        GoldCategory::factory()->count(20)->create();
        $rows = GoldCategory::all();
        echo " Insert: goldcategories \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
