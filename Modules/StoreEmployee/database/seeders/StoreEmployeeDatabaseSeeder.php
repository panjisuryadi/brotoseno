<?php

namespace Modules\StoreEmployee\database\seeders;
//use Modules\StoreEmployee\database\seeders\StoreEmployeeDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\StoreEmployee\Models\StoreEmployee;
use Carbon\Carbon;
class StoreEmployeeDatabaseSeeder extends Seeder
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
         * StoreEmployees Seed
         * ------------------
         */

        // DB::table('storeemployees')->truncate();
        // echo "Truncate: storeemployees \n";

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
        //         $data = StoreEmployee::create($row);

        //     }


        StoreEmployee::factory()->count(20)->create();
        $rows = StoreEmployee::all();
        echo " Insert: storeemployees \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
