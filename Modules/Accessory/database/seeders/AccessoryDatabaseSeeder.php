<?php

namespace Modules\Accessory\database\seeders;
//use Modules\Accessory\database\seeders\AccessoryDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Accessory\Models\Accessory;
use Carbon\Carbon;
class AccessoryDatabaseSeeder extends Seeder
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
         * Accessories Seed
         * ------------------
         */

        // DB::table('accessories')->truncate();
        // echo "Truncate: accessories \n";

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
        //         $data = Accessory::create($row);

        //     }


        Accessory::factory()->count(20)->create();
        $rows = Accessory::all();
        echo " Insert: accessories \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
