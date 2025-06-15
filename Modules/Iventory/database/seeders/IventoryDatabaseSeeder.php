<?php

namespace Modules\Iventory\database\seeders;
//use Modules\Iventory\database\seeders\IventoryDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Iventory\Models\Iventory;
use Carbon\Carbon;
class IventoryDatabaseSeeder extends Seeder
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
         * Iventories Seed
         * ------------------
         */

        // DB::table('iventories')->truncate();
        // echo "Truncate: iventories \n";

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
        //         $data = Iventory::create($row);

        //     }


        Iventory::factory()->count(20)->create();
        $rows = Iventory::all();
        echo " Insert: iventories \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
